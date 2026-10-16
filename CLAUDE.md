# Claude Instructions for nyssen.me Website

## Project Overview

This project is built with Bludit CMS. The main folder also contains two old static prototypes, `HTML/` and `HTML-v2/`, and a `/docs` folder.

**Framework:** Bludit CMS v3.22.0 (flat-file CMS)
**Theme:** NY (custom minimalist theme)
**Purpose:** Source for the live site https://nyssen.me/
**Language:** PHP 5.6+
**Content language:** English only

The site needs to be genuinely accessible in addition to being WCAG 2.2 AA compliant. Accessibility requirements can be found in [docs/accessibility.md](docs/accessibility.md).

## Project Structure

```
c:\wamp64\www\skv\nyssen\
├── bl-kernel/                     # Bludit core framework (do not modify)
├── bl-content/                    # Content storage & configuration
│   ├── databases/                 # Site configuration files
│   ├── pages/                     # Page content
│   └── uploads/                   # Media
├── bl-languages/                  # Bludit language files (do not modify)
├── bl-plugins/                    # Bludit plugins (do not modify)
├── bl-themes/
│   ├── alternative/               # Default Bludit theme (unused)
│   └── ny/                        # CUSTOM THEME
│       ├── index.php              # Theme entry point, includes inline <script> blocks
│       ├── php/                   # Template files
│       │   └── partials/          # Reusable components
│       └── assets/
│           ├── css/
│           │   ├── src/           # Source CSS
│           │   ├── style.css      # @imports the src files
│           │   └── style-min.css  # Compiled output (Prepros)
│           ├── js/                # Empty – JS lives inline in index.php
│           ├── fonts/
│           └── images/            # Theme images
├── docs/                          # Project docs (accessibility.md)
├── HTML/                          # Old static prototype (reference only)
├── HTML-v2/                       # Old static prototype (reference only)
├── index.php                      # Bludit entry point
├── prepros.config                 # Build configuration
├── CLAUDE.md                      # Instructions for Claude
├── DEPLOYMENT-NOTES.md            # Deployment notes
└── README.md                      # Project README
```

## Theme Guidelines

### Development Areas

**Location:** `bl-themes/ny/`

**PHP Templates:**
- [header.php](bl-themes/ny/php/header.php) - Site header, navigation, theme switcher
- [footer.php](bl-themes/ny/php/footer.php) - Site footer
- [home.php](bl-themes/ny/php/home.php) - Homepage layout
- [page.php](bl-themes/ny/php/page.php) - Page template
- [portfolio.php](bl-themes/ny/php/portfolio.php) - Portfolio template
- [services.php](bl-themes/ny/php/services.php) - Services listing template
- [single-service.php](bl-themes/ny/php/single-service.php) - Single service template
- [partials/](bl-themes/ny/php/partials/) - Reusable components (currently empty)
- `header-old.php`, `home-old.php`, `home-old2.php` - Earlier versions, kept for reference. Do not delete or edit.

**CSS Architecture** (imported in order by [style.css](bl-themes/ny/assets/css/style.css)):
- [src/variables.css](bl-themes/ny/assets/css/src/variables.css) - Design tokens
- Global files: `reset.css`, `general.css`
- Layout files: `helpers.css`, `grids.css`
- Component files: `buttons.css`, `header.css` (includes the theme switcher), `footer.css`
- Content files: `pages.css`
- `src/plugins/` - Styles for JS plugins (currently empty)

New CSS files must be added as an `@import` in `style.css`.

**JavaScript:**
All JavaScript is inline in [bl-themes/ny/index.php](bl-themes/ny/index.php) as `<script>` blocks. Keep it that way whenever possible and avoid separate JS files.

### Content Structure

**Location:** `bl-content/pages/`

### Critical Rules

**DO NOT Modify:**
- `bl-kernel/` - Bludit core framework
- `bl-plugins/` - Installed plugins
- `bl-languages/` - Language files

**Environment-Specific Settings:**
- Local: `http://nyssen/` (WAMP64)
- Live: `https://nyssen.me/`

**Always use** `<?php echo DOMAIN_BASE; ?>` for links (never hardcode paths)

## Design System

### Color Scheme

The site uses only four colours, defined as CSS custom properties in [variables.css](bl-themes/ny/assets/css/src/variables.css):

| Palette variable | Value | Use |
|---|---|---|
| `--light-color` | `#FBFBFB` | Light theme background / dark theme text |
| `--dark-color` | `#010101` | Light theme text / dark theme background |
| `--primary-color` | `#9C0D38` | Accent in the light theme |
| `--secondary-color` | `#FFB006` | Accent in the dark theme |

Components must use the theme variables, never the palette variables or hardcoded colours:

| Theme variable | Light theme | Dark theme |
|---|---|---|
| `--bg-color` | `#FBFBFB` | `#010101` |
| `--font-color` | `#010101` | `#FBFBFB` |
| `--accent-color` | `#9C0D38` | `#FFB006` |

**Themes:** only light and dark (no high contrast or greyscale modes). The default follows the system setting (`prefers-color-scheme`). The theme switcher in the header (an icon-only toggle button with `aria-pressed`) sets `data-theme="light"` or `data-theme="dark"` on `<html>` and saves the choice in `localStorage` (`theme` key). A small inline script in the `<head>` of [index.php](bl-themes/ny/index.php) applies the saved theme before render.

**Contrast rules:** the accent only has enough contrast against `--bg-color` in its own theme, so never put `--primary-color` on a dark background or `--secondary-color` on a light one. Text placed on an `--accent-color` background must use `--bg-color`. Any new colour combination must meet WCAG AA contrast in both themes.

### Accessibility Requirements (Critical for this project)

This project **prioritizes accessibility**. Maintain these standards:

- Semantic HTML5 markup
- ARIA labels and roles (only where native HTML is not enough)
- Keyboard navigation support
- Screen reader compatibility (test with NVDA, JAWS, VoiceOver)
- WCAG 2.2 AA color contrast ratios
- No accessibility tools panel/overlay: the site itself must be accessible. The only user setting is the light/dark theme switcher.

### Typography

This project uses modern system font stacks (system-ui) for the best possible performance.

## Common Workflows

1. **Modifying Design:**
   - Edit CSS in `bl-themes/ny/assets/css/src/`
   - Prepros compiles automatically to `style-min.css`
   - Test in browser

2. **Changing Templates:**
   - Edit PHP files in `bl-themes/ny/php/`
   - Use Bludit page methods (`$page->title()`, `$page->content()`, etc.)
   - Test functionality

3. **Adding Components:**
   - Create in `bl-themes/ny/php/partials/`
   - Test accessibility

## Deployment

- Changes are published manually via FTP (FileZilla) to https://nyssen.me/
- Changes are also committed to the GitHub repo (`origin`: github.com/nyssen-me/nyssen)
- When finishing a task, list the changed files so they can be uploaded via FTP
- See [DEPLOYMENT-NOTES.md](DEPLOYMENT-NOTES.md), including how to update Bludit

## Testing Checklist

- [ ] Works on local environment (`http://nyssen/`)
- [ ] Responsive design (mobile, tablet, desktop)
- [ ] No hardcoded URLs (uses `DOMAIN_BASE`)
- [ ] CSS compiled and minified
- [ ] Works in both light and dark themes (system default and switcher)
- [ ] Keyboard and screen reader tested

## File Organization Rules

- Modify only the `bl-themes/ny/` directory
- Never edit core Bludit files
- Keep configuration in `bl-content/databases/`
- Use Prepros for CSS compilation

## Resources

### Bludit Documentation
- [Official Website](https://www.bludit.com)
- [Documentation](https://docs.bludit.com)
- [GitHub Issues](https://github.com/bludit/bludit/issues)

### Accessibility Resources
- [WCAG 2.2 Quick Reference](https://www.w3.org/WAI/WCAG22/quickref/)
- [WebAIM Resources](https://webaim.org/resources/)

### Project-Specific Docs
- [README.md](README.md) - Project README
- [DEPLOYMENT-NOTES.md](DEPLOYMENT-NOTES.md) - Deployment notes
- [docs/accessibility.md](docs/accessibility.md) - Accessibility requirements

## Development Environment

**Local Setup:** WAMP64 on Windows
**Repository:** Git, GitHub
**Current Branch:** main
**Build Tool:** Prepros (CSS compilation)

## Key Principles

1. **Accessibility Always** - Must meet WCAG 2.2 AA and be genuinely usable
2. **Component-Based** - Build reusable, modular components
3. **Performance Matters** - Optimize assets, lazy load images, minimize requests
4. **Semantic HTML** - Use proper HTML5 elements for structure and meaning

---

**Remember:** This is the website of a website designer and developer with more than 20 years of experience, now working as a freelancer providing Digital Accessibility Services and Consultancy.
