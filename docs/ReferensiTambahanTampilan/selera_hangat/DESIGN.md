---
name: Selera Hangat
colors:
  surface: '#fcf9f8'
  surface-dim: '#dcd9d9'
  surface-bright: '#fcf9f8'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f6f3f2'
  surface-container: '#f0eded'
  surface-container-high: '#eae7e7'
  surface-container-highest: '#e4e2e1'
  on-surface: '#1b1c1c'
  on-surface-variant: '#59413a'
  inverse-surface: '#303030'
  inverse-on-surface: '#f3f0f0'
  outline: '#8d7169'
  outline-variant: '#e0bfb6'
  surface-tint: '#ac3509'
  primary: '#ac3509'
  on-primary: '#ffffff'
  primary-container: '#ff7043'
  on-primary-container: '#641800'
  inverse-primary: '#ffb59f'
  secondary: '#625f4c'
  on-secondary: '#ffffff'
  secondary-container: '#e8e3cb'
  on-secondary-container: '#686552'
  tertiary: '#286b33'
  on-tertiary: '#ffffff'
  tertiary-container: '#67ab6b'
  on-tertiary-container: '#003d12'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#ffdbd0'
  primary-fixed-dim: '#ffb59f'
  on-primary-fixed: '#3a0a00'
  on-primary-fixed-variant: '#852300'
  secondary-fixed: '#e8e3cb'
  secondary-fixed-dim: '#ccc7b0'
  on-secondary-fixed: '#1e1c0e'
  on-secondary-fixed-variant: '#4a4736'
  tertiary-fixed: '#abf4ac'
  tertiary-fixed-dim: '#90d792'
  on-tertiary-fixed: '#002107'
  on-tertiary-fixed-variant: '#07521d'
  background: '#fcf9f8'
  on-background: '#1b1c1c'
  surface-variant: '#e4e2e1'
typography:
  display-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 36px
    fontWeight: '800'
    lineHeight: 44px
    letterSpacing: -0.02em
  headline-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
  title-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 18px
    fontWeight: '600'
    lineHeight: 24px
  body-md:
    fontFamily: Be Vietnam Pro
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 26px
  body-sm:
    fontFamily: Be Vietnam Pro
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-bold:
    fontFamily: Be Vietnam Pro
    fontSize: 12px
    fontWeight: '700'
    lineHeight: 16px
    letterSpacing: 0.05em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  unit: 4px
  xs: 4px
  sm: 8px
  md: 16px
  lg: 24px
  xl: 32px
  container-margin: 20px
  gutter: 16px
---

## Brand & Style

This design system is built to evoke the warmth of a home kitchen while maintaining the energetic, mobile-first speed expected by Indonesian Gen Z. The visual narrative centers on "The Joy of Cooking," moving away from clinical utility toward a modern, appetizing aesthetic. 

The style is **Modern Tactile**, blending clean minimalism with soft, physical depth. It prioritizes high-quality, large-scale food photography that acts as the primary "texture" of the UI. Elements feel approachable and "squishy" through generous rounding, while high-contrast accents ensure the app remains functional in bright kitchen environments where the user may be glancing at a device from a distance.

## Colors

The palette is anchored in hunger-inducing warmth. 
- **Warm Orange (#FF7043)**: The primary action color, used for CTA buttons, progress indicators, and active states. It mimics the glow of a stovetop and fresh spices.
- **Cream (#FFF9E1)**: Used as a secondary background color for cards and containers to reduce eye strain and differentiate content sections from the pure white global background.
- **Soft Green (#81C784)**: Reserved for health indicators, "halal" tags, fresh ingredient callouts, and success states.
- **High-Contrast Neutral (#2D2D2D)**: Used for primary text to ensure maximum legibility against the light backgrounds, essential for reading recipes while cooking.

## Typography

This design system utilizes **Plus Jakarta Sans** for headings to provide a friendly, Indonesian-born geometric character that feels modern and optimistic. For long-form recipe instructions and body text, **Be Vietnam Pro** is used due to its exceptional readability and warm, contemporary curves. 

Large line-heights are prioritized in recipe steps to prevent users from losing their place while multitasking in the kitchen. Labels use uppercase with slight tracking for better scanning of nutritional data and prep times.

## Layout & Spacing

The design system employs a **Fluid-Edge Grid**. While the content expands to fill mobile screens, it maintains a strict 20px "Safe Zone" margin on the left and right to prevent thumb-clutter. 

A 4px baseline rhythm is used to ensure vertical harmony. Spacing between recipe steps is intentionally large (24px+) to create a "breathable" interface that doesn't feel overwhelming when the user is dealing with messy hands and multiple ingredients.

## Elevation & Depth

Visual hierarchy is established through **Ambient Shadows** and **Tonal Layering**. 
- **Level 0 (Base)**: Pure white (#FFFFFF) background.
- **Level 1 (Cards)**: Cream (#FFF9E1) surfaces with a very soft, diffused shadow (10% opacity Orange-Tinted Gray) to make recipe cards feel "lifted" and touchable.
- **Level 2 (Floating Actions)**: Buttons and primary CTAs use a more pronounced shadow to indicate interactivity.

Avoid harsh black shadows; instead, use a subtle tint of the primary orange (#FF7043) at 5-8% opacity for shadows to maintain the warm, appetizing glow of the interface.

## Shapes

The shape language is defined by **High Circularity**. There are no sharp corners in this design system.
- **Standard UI elements** (Inputs, small buttons): 0.5rem (8px).
- **Recipe Cards & Main Containers**: 1.5rem (24px) for a soft, friendly, and premium look.
- **Images**: Must always match the container radius.
- **Buttons**: Should lean toward fully rounded (pill-shaped) to maximize the "friendly" Gen Z aesthetic.

## Components

- **Recipe Cards**: Use a vertical stack with a 4:5 image ratio. The bottom 30% of the card uses a Cream background for title and "Time to Cook" labels.
- **Primary Buttons**: Bold Orange (#FF7043) backgrounds with White text. Use a slight "bounce" animation on press.
- **Ingredient Chips**: Cream background with Orange text; include small icons for "easy-to-find" ingredients.
- **Step Indicators**: Large, bold numbers in Plus Jakarta Sans to keep users oriented during the cooking process.
- **Filter Tags**: Use a Soft Green (#81C784) for "Vegan" or "Healthy" tags to provide instant visual categorization.
- **Cooking Mode Toggle**: A prominent, high-contrast floating button that enters a "Hands-Free" or "Full-Screen View" for easier reading while cooking.