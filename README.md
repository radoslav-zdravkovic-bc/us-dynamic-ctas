# US Dynamic CTAs Plugin

The plugin is used for CTA blocks display on US sites.
It allows you to display different bonus info for different US states.

## Installation

Before you install the plugin, makes sure that you have
ACF Pro and BC Geolocation plugins installed.

Once you install it, a new WP admin menu item will apear -  Dynamic CTAs, 
with two submenu items.

## How to use it?

After the installation process, navigate to Shortcodes Settings (/wp-admin/admin.php?page=shortcodes-settings).
In this section, you have General Settings tab where you can set colours, and you have Shortcodes tab, the place
where you'll create shortcodes.

#### Generating Shortcodes

Go to Shortcodes tab and click Add Row button. Add required data to the fields.
On the right side of a row, you'll have to set a bookmaker name and upload its logo.
On the left, you'll have to add bonus info for certain states. Desired state is choosen from 
a dropdown menu. New state is added by clicking Add Row button in the left box.
Don't forget to choose default info (displayed in states for which we didn't set the CTA).
Pay attention at Bookmaker Field, because bookmaker name is the only shortcode attribute you'll need.
Shortcodes should look like this [cta_shortcode bookmaker="bookmaker_name"] 
Add it to your WP posts or page in order to display CTA.


