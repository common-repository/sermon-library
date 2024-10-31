=== White Harvest Sermon Library  ===
Contributors: reality66
Donate link: https://whiteharvest.net
Tags: media, directory, sermons, church, podcasts
Requires at least: 4.0
Tested up to: 4.8
Requires PHP: 5.4
Stable tag: 1.1.1
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Organzize and share media in the format of video, audio, and file downloads

== Description ==

The White Harvest Sermons plugin enables a shortcode that can display a searchable, sortable, list of media.

**What Makes Sermon Library Different**

[youtube https://www.youtube.com/watch?v=DtLWaZnp5wU]

* **Search:** Fast, simple, searching – like Google (not drop-down menus)
* **Reach:** Create a podcast with Blubrry the world’s largest podcast platform
* **Efficiency:** Reduce the amount of work to keep your site updated

= Front End Demo - How It Works =

[youtube https://www.youtube.com/watch?v=JFtIAvWlEPs]

= Back End Demo - How To Configure Your Sermons =

[youtube https://www.youtube.com/watch?v=n_UBmDOjV74]

= Live Demo =

Check out a [live demo of the Sermon Library plugin here](https://sermons.whiteharvest.net/)

= Using The Shortcode =

Basic Usage [wh_sermons]

Given no additional parameters, the [wh_sermons] shortocde lists all sermons in descending chronological order.

Parameters

Certain segmented groupings of sermons can be displayed by passing parameters to the shortcode. The values of the parameters are the slugs set in the series, books, or teachers sections.

Example:
Only display sermons from the Gospel books.
books="book1,book2,book3"
[wh_sermons books="matthew,mark,luke,john"]

Example:
Only show sermons tagged with a specific series
series="heart-to-hearts"
[wh_sermons series="heart-to-hearts"]

Example:
Only show sermons by Rick Gaston
teachers="rick-gaston"
[wh_sermons teacher="rick-gaston"]

Example:
Show a maximum of 30 sermons by Rick Gaston
teachers="rick-gaston"
limit="30"
[wh_sermons teacher="rick-gaston" limit="30"]

= Latest Sermon Widget =

The Latest Sermon widget makes mataining your site fast and efficient by automatically updating to always show the latest sermon. Set up the Latest Sermon widget to display the most recent sermon from any series, such as your Sunday sermons or your Wednesday sermons. Now, every time you upload a new sermon, the Latest Sermon widget will automatically pull in the most recent sermon from the series.

== Screenshots ==

1. Blazingly fast search - works just like Google.
2. Latest Sermon widget automatically shows your most recent sermon
3. Configure the latest sermon widget
4. Add video to your sermons and categorize them by book, series, teacher

== Upgrade Notice ==

As always, it's a good idea to backup your site before upgrading your WordPress plugins. Having said that, there are no known issues with upgrading. All of your data and features should be migrated seamlessly to the next version.

== Installation ==

To Install Sermon Library:

1. Download the white-harvest-sermons.zip file
2. Extract the zip file so that you have a folder called white-harvest-sermons
3. Upload the 'white-harvest-sermons' folder to the `/wp-content/plugins/` directory
4. Activate the plugin through the 'Plugins' menu in WordPress

To Uninstall White Harvest Sermons

1. Deactivate White Harvest Sermons thorugh the 'Plugins' menu in WordPress
2. Click the "delete" link to delete the plugin. This will remove all
of the White Harvest Sermons files from your plugins directory. It will NOT delete any posts
from your WordPress site.

== Changelog ==

= 1.1.1 = 
* Register sermon permalinks during plugin activation

= 1.1.0 = 
* New: Add ability to change slugs for sermons, books, series, and teachers
* New: Create a settings page for managing the plugins settings
* New: Add check to for PowerPress plugin dependency
* Update: Add spacing under the search box in the mobile view
* Fix: Teacher filter in wh_sermons shortcode was not always displaying all the sermons from the specified teacher

= 1.0.0 =
* New: Latest sermon widget
* New: Visual shortcode editor 
* Fix: Resolve several PHP and JavaScript notices
* Fix: Audio file lookup for new Blubrry data structure

= 0.2.2 =
* Use HTML5 audio player instead of WP audio shortcode
* Clean up CSS borders around sermon archive table

= 0.2.1 =
* Add scripture reference to media row title

= 0.2.0 = 
* Remove dependency on Simple Music Widget
* Add meta box for scripture reference
* Use scripture reference from meta box in wh_sermons_single footer description

= 0.1.2 = 
* Add shortcode to show latest sermon from specified series

= 0.1.1 =
* Add date to search placeholder

= 0.1.0 =
* Initial release
