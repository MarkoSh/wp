=== WooCommerce Wholesale Prices ===
Contributors: jkohlbach, RymeraWebCo, Rymera01
Donate link:
Tags: woocommerce wholesale, wholesale plugin, wholesale prices, wholesale pricing, woocommerce wholesale pricing, woocommerce, wholesale
Requires at least: 3.4
Tested up to: 4.7.5
Stable tag: 1.4.5 
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Provide special pricing to wholesale customers in WooCommerce.

== DESCRIPTION ==

***VISIT OUR WEBSITE:***

Click here: [Wholesale Suite for WooCommerce](https://wholesalesuiteplugin.com)

Check out the [WooCommerce Wholesale Prices Premium Add-on](https://wholesalesuiteplugin.com/product/woocommerce-wholesale-prices-premium/)

***OTHER PREMIUM PLUGINS:***

1. [WooCommerce Wholesale Order Form](https://wholesalesuiteplugin.com/product/woocommerce-wholesale-order-form/)
1. [WooCommerce Wholesale Lead Capture](https://wholesalesuiteplugin.com/product/woocommerce-wholesale-lead-capture/)

**WOOCOMMERCE WHOLESALE PRICES FREE EDITION**

***WooCommerce Wholesale Prices*** gives WooCommerce store owners the ability to supply specific users with wholesale pricing for their product range.

We've made entering wholesale prices as simple as it should be:

1. Install & activate the WooCommerce Wholesale Prices plugin
1. Navigate to the product you wish to enter wholesale pricing for
1. If it's a Simple product, you'll find a wholesale price box on the General tab, if it's a Variable product, each variation will have a wholesale price box
1. Change the user role of the customers you wish to grant wholesale access to the new Wholesale Customer role

Some features at a glance:

**SIMPLE WHOLESALE PRICING**

No complex setups, it's simply another built-in user role (just like regular Customers) and another pricing box for the information. The plugin takes care of the rest.

**FLEXIBILITY**

You don't have to set wholesale pricing for all of your products you can do just a sub-set.

You can also quick edit Simple product types for easy management.

**GREAT FOR USERS**

Display of your wholesale prices is automatic once your wholesale customers login to their account. The plugin takes care of the front end display.

**COMPATIBLE WITH OTHER PLUGINS**

Compatible with loads of complementary plugins, such as hundreds of shipping and payment gateways, WooCommerce Currency Switcher by Aelia (even with our free Wholesale Prices plugin!), WPML language switching plugin, plus loads more.

**PREMIUM ADD-ON**

Click here for information about the [WooCommerce Wholesale Prices Premium add-on](https://wholesalesuiteplugin.com/product/woocommerce-wholesale-prices-premium/).

== Installation ==

1. Upload the `woocommerce-wholesale-prices/` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Visit the product you wish to edit and enter the wholesale price
1. Change the customer's user role by going to Users->All Users, clicking edit on the user, and changing their "Role" to the Wholesale Customer role.

== Frequently asked questions ==

We'll be publishing a list of frequently asked questions in our knowledge base soon.

== Screenshots ==

Plenty of amazing screenshots for this plugin and more over at:
[https://wholesalesuiteplugin.com/product/woocommerce-wholesale-prices-premium/](https://wholesalesuiteplugin.com/product/woocommerce-wholesale-prices-premium/)

== Changelog ==

= 1.4.5 =
* Bug Fix: Support for old php versions

= 1.4.4 =
* Improvement: Improve support for WC duplicate product feature
* Improvement: Minor code improvements

= 1.4.3 =
* Bug Fix: Issues with multisite install

= 1.4.2 =
* Improvement: Minor code improvements

= 1.4.1 =
* Bug Fix: Errors thrown when wwpp less than 1.14.0 is active thus preventing wwpp update

= 1.4.0 =
* Feature: Add WPML support
* Improvement: Add compatibility with upcoming WooCommerce version 3.0.0
* Improvement: Major code refactor for effeciency , speed and maintanability

= 1.3.2 = 
* Bug Fix: Wholesale prices not showing properly on variable products with huge number of variations

= 1.3.1 =
* Improvement: Add compatibility with upcoming WooCommerce version 2.7.0
* Improvement: Refactor codebase for effeciency and maintanability

= 1.3.0 =
* Feature: Multi Site Compatibility
* Improvement: Apply a wrapping css class name to the wholesale options on product edit screens
* Improvement: Embed new data on cart/orders for more accurate reporting in the future
* Improvement: Major code refactor for effeciency , speed and maintanability
* Bug Fix: Fatal error: Class 'WWP_Helper_Functions' not found
* Bug Fix: Fix typo in filter 'wwof_settings_section_content', should be wwp not wwof
* Bug Fix: When changing product categories on variable product and dont open variations tab, have_wholesale_price meta on parent variable product is not set properly
* Bug Fix: Deactivate function callback is not firing

= 1.2.10 =
* Bug Fix: Rebase keys on array returned on getUserWholesaleRole
* Bug Fix: Error notice relating to array_intersect on getUserWholesaleRole function

= 1.2.9 =
* Improvement : Rename "plugin settings" to just "settings" on the plugin listing
* Bug Fix: Properly check for dependencies and properly trigger activation code base
* Bug Fix: If you modify an attribute then attempt to bulk set wholesale pricing it doesn't show the input alert box
* Bug Fix: Tidy up code base, remove unnecessary codes

= 1.2.8 =
* Improvement: If no price set for a product, don't bother to construct wholesale price html
* Bug Fix: Doesn't seem to properly change the price html

= 1.2.7 =
* Bug Fix: Duplicate wholesale price shows when all variations have the same regular and wholesale price

= 1.2.6 =
* Bug Fix: Pricing accordion for Aelia currency switcher broken on simple products

= 1.2.5 =
* Bug Fix: WC2.6.0: Display bug with crossed out regular prices when wholesale price is being displayed
* Bug Fix: When regular prices are left blank on variations, notices are shown (For none wholesale users)
* Improvement: Add filters for wholesale prices suffix

= 1.2.4 =
* Bug Fix: Add support for custom product types ( composite, bundle, etc.. ) on calculation of cart on cart widget

= 1.2.3 =
* Feature: Allow setting of wholesale prices per wholesale role on all variable product variations via custom bulk action
* Improvement: Tidy up internationalization
* Improvement: Tidy up code base for extensibility

= 1.2.2 =
* Improvement: Add additional hooks to settings code base for better extensibility.

= 1.2.1 =
* Bug Fix: When aelia currency switcher plugin is not present, variations of a variable product has some issues on displaying wholesale price on the backend

= 1.2.0 =
* Feature: Integrate to Aelia Currency Switcher Plugin
* Bug Fix: When variable product has same regular price, wholesale price don't get displayed on the front end.
* Bug Fix: Properly mark products with wholesale price if its category is later updated with a wholesale discount ( WWPP )
* Bug Fix: UI fixes required for WC 2.5 & WP 4.4
* Improvement: Update upgrade notice screenshot on settings page

= 1.1.7 =
* Improvement: Code enhancements

= 1.1.6 =
* Bug Fix: Fix "Only Show Wholesale Products To Wholesale Users" option behaviour when variations of a variable product is paginated

= 1.1.5 =
* Bug Fix: Bug fixes and code enhancements

= 1.1.4 =
* Bug Fix: Fix duplicate failure to meet wholesale price notice
* Improvement: Tidy up internationalization code base

= 1.1.3 =
* Improvement: Improve integration to WooCommerce 2.4.x series new "Save Changes" button on the variations section of a variable product

= 1.1.2 =
* Improvement: Refactor activation code making the plugin more efficient
* Improvement: Integrate to WooCommerce 2.4.x series new "Save Changes" button on the variations section of a variable product
* Feature: Add current user wholesale role on the class of the body tag

= 1.1.1 =
* Bug Fix: Fix price suffix doubling up on variable products

= 1.1.0 =
* Improvement: Add additional helper functions
* Improvement: Enhance cleaning up procedures on deactivation
* Improvement: Translation ready

= 1.0.9 =
* Bug Fix: Properly display wholesale pricing when changing product types
* Bug Fix: Properly display product price range for variable products

= 1.0.8 =
* Bug Fix: Improve European style prices support

= 1.0.7 =
* Bug Fix: Refactor logic on implementation of minimum price requirements

= 1.0.6 =
* Bug Fix: Properly mark wholesale products if wholesale price is set
* Minor Feature: Add additional filter and action hooks

= 1.0.5 =
* Bug Fix: Allow saving of European style prices ( comma used as decimal separator )

= 1.0.4 =
* Bug Fix: Add additional meta flags to be used within the loop to determine if products have wholesale prices defined

= 1.0.3 =
* Bug Fix: Refactor logic of applying wholesale price to variable product variation

= 1.0.2 =
* Bug Fix: Add some meta flags to be used within the loop to determine if products have wholesale prices defined
* Bug Fix: Tidy up data displayed on the custom wholesale prices column on the product listing page on the backend

= 1.0.1 =
* Feature: Added wholesale price columns to Product listing page on backend
* Feature: Added preview of settings available in Premium
* Feature: Added link to settings page from installed plugins screen

= 1.0.0 =
* Initial version

== Upgrade notice ==

There is a new version of WooCommerce Wholesale Prices available.
