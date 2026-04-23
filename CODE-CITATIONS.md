# Code Citations and References

This file documents code sources, inspirations, and references used in the Labee Slider WordPress plugin development.

## Third-Party Code References

### WordPress Media Uploader Implementation
**Source:** [WordPress Core Media API](https://codex.wordpress.org/Javascript_Reference/wp.media)  
**Usage:** Custom media uploader functionality in `js/upload.js`  
**License:** GPL-2.0+ (WordPress Core)  
**Date Accessed:** April 23, 2026

**Original Reference:**
```javascript
// Basic WordPress media uploader pattern
wp.media({
    title: 'Select Media',
    button: { text: 'Use this media' },
    multiple: false
}).on('select', function() {
    var attachment = custom_uploader.state().get('selection').first().toJSON();
    // Handle attachment data
}).open();
```

### Bootstrap Carousel Integration
**Source:** [Bootstrap Documentation](https://getbootstrap.com/docs/4.0/components/carousel/)  
**Usage:** Responsive carousel functionality in slider output  
**License:** MIT  
**Version:** Bootstrap 3.x/4.x compatible  
**Date Accessed:** April 23, 2026

### PrettyPhoto Lightbox
**Source:** [PrettyPhoto GitHub](https://github.com/scaron/prettyphoto)  
**Usage:** Image gallery lightbox in `js/main.js`  
**License:** GPL-2.0+ / MIT  
**Date Accessed:** April 23, 2026

## Development Resources

### WordPress Coding Standards
**Reference:** [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)  
**Applied to:** PHP, JavaScript, and CSS code formatting  
**Date Referenced:** April 23, 2026

### WordPress Plugin Development
**Reference:** [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/)  
**Applied to:** Plugin architecture, hooks, and security practices  
**Date Referenced:** April 23, 2026

## Code Attribution Notes

- All code in this plugin is original or properly adapted from WordPress Core
- Third-party libraries (Bootstrap, PrettyPhoto) are included under their respective licenses
- No unlicensed or copyrighted code is used without permission
- All modifications are documented in the changelog

## License Compliance

This plugin complies with:
- WordPress GPL-2.0+ license requirements
- Third-party library licenses (MIT, GPL-2.0+)
- Proper attribution for all code sources

---

*This file serves as documentation for code origins and license compliance.*