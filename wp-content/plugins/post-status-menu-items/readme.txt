=== Post Status Menu Items ===
Contributors: mrwweb
Tags: post status, post statuses, admin menu, WP Admin, drafts
Requires at least: 3.8
Tested up to: 4.7.4
Stable tag: 1.5.0
Donate Link: http://www.networkforgood.org/donation/MakeDonation.aspx?ORGID2=522061398
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds post status links–e.g. "Draft" (7)–to post type admin menus and a few other nice goodies.

== Description ==

This plugin is useful for people who regularly use all or most of the post statuses with Posts, Pages, or Custom Post Types. Post Status Menu Items does the following:

1. Show each post status and number of posts with that status (e.g. "Drafts (7)") in each post type's admin menu.
1. Show the number of Posts with each post status in the "Right Now" / "At a Glance" admin Dashboard Widget.
1. Show post status icons with each status at the top of admin post list pages.

Options give control over which post statuses are displayed and in which menus those statuses are displayed. Post statuses in the "Right Now" / "At a Glance" admin Dashboard widget can also be turned off.

Screenshots of all features and settings are available on [the Screenshots page](http://wordpress.org/plugins/post-status-menu-items/screenshots/).

**Notes**

- Plugin settings available on **Settings > Writing**.
- Statuses with 0 posts are never displayed.
- Posts are the only post type for which the post status menu items are enabled by default.

This plugin works with custom statuses created by [Edit Flow](http://wordpress.org/extend/plugins/edit-flow/), [Archived Post Status](https://wordpress.org/plugins/archived-post-status/), [Advanced Custom Field PRO "Sync Available" status](http://www.advancedcustomfields.com/resources/synchronized-json/), [Simple Page Ordering](https://wordpress.org/plugins/simple-page-ordering/), and [`register_post_status()`](http://codex.wordpress.org/register_post_status).


= Other Plugins by MRWweb =

* [Feature a Page Widget](http://wordpress.org/plugins/feature-a-page-widget/) - Shows a summary of any Page in any sidebar.
* [MRW Web Design Simple TinyMCE](https://wordpress.org/plugins/mrw-web-design-simple-tinymce/) - A compact page editor to encourage good formatting.
* [Post Type Archive Description](http://wordpress.org/plugins/post-type-archive-descriptions/) - Enables an editable description for a post type to display at the top of the post type archive page.

== Installation ==

1. Upload the "post-status-menu-items" folder to the `/wp-content/plugins/` directory of your WordPress site.
1. Activate the plugin, "Post Status Menu Items" through the "Plugins" menu in WordPress

**OR**

1. From the Dashboard, go to Plugins > Add New.
1. Search for "Post Status Menu Items."
1. Click "Install."
1. Click "Activate."

== Frequently Asked Questions ==

= Where are the Settings? =
* Settings > Writing.
* Look for the "Settings for 'Post Status Menu Items'" section.

= How Do I Turn the Menus On or Off for a Post Type? =
* Go to the plugin's settings (see above).
* Check or uncheck the post types you do or don't want to display post statuses for.
* Click "Save Changes"

= Can I suggest a feature? =
* Sure thing. Do it on this [thread in the Support Forums](http://wordpress.org/support/topic/plugin-post-status-menu-items-post-your-feature-suggestions-here).

== Screenshots ==
1. The "Posts" flyout menu showing some post statuses.
2. The "Posts" expanded menu showing some post statuses.
3. Post Status icons also appear with each status in the "All Posts" admin screen.
4. Show post statuses in the "At a Glance" widget in WordPress 3.8 or later.
5. Plugin options on Settings > Writing (specific post types and post statuses vary by site).

== Changelog ==
= 1.5.0 (April 25, 2017) =
* [New!] Add icon for Yoast SEO's new "Cornerstone Articles" "status"
* [Tweak] Make post status icons on "All Posts" pages slightly smaller.

= 1.4.0 (December 14, 2015) =
* [New] Icon for [Advanced Custom Field PRO "Sync Available" status](http://www.advancedcustomfields.com/resources/synchronized-json/)
* [New] Icon for [Simple Page Ordering](https://wordpress.org/plugins/simple-page-ordering/)
* [Compat] Remove CSS for support before 3.8
* [Update] required and tested versions

= 1.3.3 (February 26, 2015) =
* [Fix] "Undefined Index" error (Thanks, [@leac](https://wordpress.org/support/profile/leac)!)
* [Change] code formatting to always use braces for `if` statements.

= 1.3.2 (January 21, 2015) =
* [New] Settings link on Plugins screen
* [New] Define icon for post statuses named "archive" and "archived."
* [Change] Readme tweaks to Installation and front page.
* [i18n] Update POT file for settings link.

= 1.3.1 (February 13, 2014) =
* [Fix] Broken Trashicon Dashicon.
* [Fix] Add additional capability check to avoid Pages showing for Contributors. Thanks @csigncsign for reporting this.
* [Fix] Hide Posts screen status icons in < WP3.8.
* [New] Set better icons for "All" and "Mine" statuses.
* [Change] Remove conditional loading of stylesheet. Load on all admin pages.
* [readme] New and reordered screenshots for 3.8.

= 1.3.0 (December 12, 2013) =
* [New] In WordPress 3.8+, display Posts statuses in "At a Glance" Dashboard widget with awesome Dashicons. (Uses old "Right Now" widget setting. Statuses remain in the "Right Now" widget in older verions of WordPress.)
* [New] Status Icons added to top of "post list" admin page. (Icons courtesty of the awesome new [dashicons](http://melchoyce.github.io/dashicons/).)
* [i18n] Support for new [WordPress 3.7+ Language Packs](http://ottopress.com/2013/language-packs-101-prepwork/).
* [i18n] Updated .pot in `/langauges/`
* [Settings] Revised settings labels for [hopefully!] better clarity.
* [Misc] Add Screenshots showing new "At a Glance" widget and Post Status icons on posts list admin pages.
* [Misc] Clarify description of plugin in readme.
* [Regression] Crappy "At a Glance" HTML markup courtesy of [#26495](http://core.trac.wordpress.org/ticket/26495). [Bug filed: #26571.](http://core.trac.wordpress.org/ticket/26571)

= 1.2.1 (September 27, 2013) =
* Added capability check so Subscribers don't see statuses. (Thanks, [@benlobaugh](http://profiles.wordpress.org/blobaugh/)!)
* Cleaned up "Right Now" dashboard widget styles with MP6.

= 1.2.0 =
Added Post statuses to "Right Now" dashboard widget.

= 1.1.2 =
* Second headers already sent fix. This one was an encoding issue.

= 1.1.1 =
* Fixed "headers already sent" error with some plugins.
* Added screenshot of plugin options

= 1.1.0 =
* Added support for custom post statuses made with Edit Flow or `register_post_status()`.
* Added option to control which post stati are displayed (see Settings > Writing).
* Moved/added all options to single option in the database. (Previously saved options should be automatically migrated.)
* First pass at inline documentation.
* Now translatable (i.e. i18n).
* Updated version compatibility #.

= 1.0.1 =
* Updated "Requires at least" version to 3.0 after some research.
* Tweaked function that adds menu items to be slightly more efficient (avoiding array_push).

= 1.0 =
* Almost a complete rewrite. Again :)
* Added "Private" and "Trash" Statuses.
* Added support for Pages and Custom Post Types.
* Added options to toggle display of menu items for all post types (Settings > Writing).
* Added status counts to each menu item.
* Statuses with 0 posts are now hidden.

= 0.2 =
* Rewrite to hopefully avoid conflicts with other plugins.

= 0.1 =
* First release.

== Upgrade Notice ==
= 1.4 =
New icons for custom and plugin post stati. Drop support for old WordPress (<3.8)

= 1.3.3 =
Fix a notice in some circumstances.

= 1.3.2 =
Link to settings added to Plugins page. Support for Archived Post Status plugin.

= 1.3.1 =
Permissions fix for Contributors. Improved icons for 3.8. Better <3.8 support.

= 1.3.0 =
New status icons & WordPress 3.8 support. Language pack support.

= 1.2.1 =
Minor style and functionality fixes.

= 1.2.0 =
New! Post statuses shown in "Right Now" dashboard widget.

= 1.1.2 =
Second headers already sent fix. Different issue than 1.1.1.

= 1.1.1 =
Bug fix for "headers already sent"/white screen error.

= 1.1.0 =
New option to hide specific statuses. Now compatible with custom statuses, Edit Flow plugin, etc.

= 1.0.1 =
This update contains a very minor performance improvement.

= 1.0 =
New features! 1.0 adds Page and Custom Post Type support, post counts, and hides empty statuses.