<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeVipAccessTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $chef;
    private User $regularUser;
    private User $vipUser;
    private Recipe $vipRecipe;
    private Recipe $freeRecipe;

    protected function setUp(): void
    {
        parent::setUp();

        // Create users using UserFactory
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->chef = User::factory()->create(['role' => 'chef']);
        $this->regularUser = User::factory()->create(['role' => 'user', 'is_vip' => false]);
        $this->vipUser = User::factory()->create(['role' => 'user', 'is_vip' => true, 'vip_expires_at' => now()->addDays(10)]);

        // Create category manually
        $category = Category::create([
            'name' => 'Main Course',
            'slug' => 'main-course',
        ]);

        // Create recipes manually with required json fields
        $this->vipRecipe = Recipe::create([
            'chef_id' => $this->chef->id,
            'category_id' => $category->id,
            'title' => 'VIP Recipe Test',
            'slug' => 'vip-recipe-test',
            'description' => 'A VIP Recipe Description',
            'prep_time' => 10,
            'cook_time' => 15,
            'difficulty' => 'easy',
            'is_vip_content' => true,
            'status' => 'published',
            'ingredients' => [],
            'cooking_steps' => [],
            'allergens' => [],
        ]);

        $this->freeRecipe = Recipe::create([
            'chef_id' => $this->chef->id,
            'category_id' => $category->id,
            'title' => 'Free Recipe Test',
            'slug' => 'free-recipe-test',
            'description' => 'A Free Recipe Description',
            'prep_time' => 10,
            'cook_time' => 15,
            'difficulty' => 'easy',
            'is_vip_content' => false,
            'status' => 'published',
            'ingredients' => [],
            'cooking_steps' => [],
            'allergens' => [],
        ]);
    }

    public function test_guest_cannot_access_vip_recipe(): void
    {
        $response = $this->get(route('recipes.show', $this->vipRecipe->slug));
        $response->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_access_vip_recipe(): void
    {
        $response = $this->actingAs($this->regularUser)
            ->get(route('recipes.show', $this->vipRecipe->slug));
        $response->assertRedirect(route('vip.index'));
        $response->assertSessionHas('error');
    }

    public function test_vip_user_can_access_vip_recipe(): void
    {
        $response = $this->actingAs($this->vipUser)
            ->get(route('recipes.show', $this->vipRecipe->slug));
        $response->assertOk();
    }

    public function test_admin_can_access_vip_recipe(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('recipes.show', $this->vipRecipe->slug));
        $response->assertOk();
    }

    public function test_chef_can_access_vip_recipe(): void
    {
        $response = $this->actingAs($this->chef)
            ->get(route('recipes.show', $this->vipRecipe->slug));
        $response->assertOk();
    }

    public function test_guest_cannot_access_free_recipe(): void
    {
        $response = $this->get(route('recipes.show', $this->freeRecipe->slug));
        $response->assertRedirect(route('login'));
    }

    public function test_recipe_publishing_sends_notifications_to_users(): void
    {
        // Category
        $category = Category::first();

        // Count existing notifications
        $initialCount = Notification::count();

        // Create a new draft recipe (should not notify)
        $draftRecipe = Recipe::create([
            'chef_id' => $this->chef->id,
            'category_id' => $category->id,
            'title' => 'Draft Recipe Test',
            'slug' => 'draft-recipe-test',
            'description' => 'Draft recipe description',
            'prep_time' => 10,
            'cook_time' => 15,
            'difficulty' => 'easy',
            'is_vip_content' => false,
            'status' => 'draft',
            'ingredients' => [],
            'cooking_steps' => [],
            'allergens' => [],
        ]);

        $this->assertEquals($initialCount, Notification::count());

        // Publish the draft recipe (should notify regular and VIP users)
        $draftRecipe->update(['status' => 'published']);

        // Check that notifications were sent to regular and VIP users (total 2 users with 'user' role)
        $this->assertEquals($initialCount + 2, Notification::count());
    }

    public function test_member_can_save_recipe(): void
    {
        $response = $this->actingAs($this->regularUser)
            ->post(route('recipes.save', $this->freeRecipe->id));
        $response->assertRedirect();
        $this->assertTrue($this->regularUser->savedRecipes()->where('recipe_id', $this->freeRecipe->id)->exists());
    }

    public function test_admin_and_chef_cannot_save_recipe(): void
    {
        // Test Admin
        $response = $this->actingAs($this->admin)
            ->post(route('recipes.save', $this->freeRecipe->id));
        $response->assertSessionHas('error', 'Hanya member yang dapat memfavoritkan resep.');
        $this->assertFalse($this->admin->savedRecipes()->where('recipe_id', $this->freeRecipe->id)->exists());

        // Test Chef
        $response = $this->actingAs($this->chef)
            ->post(route('recipes.save', $this->freeRecipe->id));
        $response->assertSessionHas('error', 'Hanya member yang dapat memfavoritkan resep.');
        $this->assertFalse($this->chef->savedRecipes()->where('recipe_id', $this->freeRecipe->id)->exists());
    }

    public function test_comment_moderation_flow_notifications(): void
    {
        // 1. Regular user leaves a comment/rating
        $response = $this->actingAs($this->regularUser)
            ->post(route('recipes.rate', $this->freeRecipe->id), [
                'rating' => 5,
                'comment' => 'This is a test comment',
            ]);
        $response->assertRedirect();

        // Chef should NOT have any notifications yet
        $chefNotificationCount = Notification::where('user_id', $this->chef->id)->count();
        $this->assertEquals(0, $chefNotificationCount);

        // Admin should have a notification with a comment_rating_id
        $adminNotification = Notification::where('user_id', $this->admin->id)
            ->whereNotNull('comment_rating_id')
            ->first();
        $this->assertNotNull($adminNotification);

        $commentRating = $adminNotification->commentRating;
        $this->assertNotNull($commentRating);
        $this->assertFalse($commentRating->is_approved);

        // 2. Admin approves the comment via admin.moderation.approve
        $approveResponse = $this->actingAs($this->admin)
            ->patch(route('admin.moderation.approve', $commentRating->id));
        $approveResponse->assertRedirect();

        // Comment should be approved
        $commentRating->refresh();
        $this->assertTrue($commentRating->is_approved);

        // Admin notification should be marked as read
        $adminNotification->refresh();
        $this->assertTrue($adminNotification->is_read);

        // Chef should now have a notification
        $chefNotification = Notification::where('user_id', $this->chef->id)->first();
        $this->assertNotNull($chefNotification);
        $this->assertStringContainsString('ulasan', strtolower($chefNotification->title));
    }

    public function test_comment_rejection_flow_notifications(): void
    {
        // 1. Regular user leaves a comment/rating
        $response = $this->actingAs($this->regularUser)
            ->post(route('recipes.rate', $this->freeRecipe->id), [
                'rating' => 4,
                'comment' => 'Another comment',
            ]);
        $response->assertRedirect();

        // Get admin notification and comment
        $adminNotification = Notification::where('user_id', $this->admin->id)
            ->whereNotNull('comment_rating_id')
            ->first();
        $commentRating = $adminNotification->commentRating;

        // 2. Admin rejects (deletes) the comment
        $rejectResponse = $this->actingAs($this->admin)
            ->delete(route('admin.moderation.destroy', $commentRating->id));
        $rejectResponse->assertRedirect();

        // Comment should be deleted
        $this->assertSoftDeleted('comments_ratings', ['id' => $commentRating->id]);

        // Admin notification should be deleted
        $this->assertDatabaseMissing('user_notifications', ['id' => $adminNotification->id]);

        // Chef should NOT have any notifications
        $chefNotificationCount = Notification::where('user_id', $this->chef->id)->count();
        $this->assertEquals(0, $chefNotificationCount);
    }
}
