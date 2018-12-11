=== SoulCache ===
Contributors: gingersoulrecords, xedin.unknown
Tags: cache
Requires at least: 4.7
Tested up to: 4.9.8
Requires PHP: 5.4.9
Stable tag: trunk
License: GLPv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A pre-caching and pre-fetching utility to increase performance on WordPress websites.

== Description ==
This is a WordPress plugin that helps use the little known capabilities of modern browsers to increase
perceived loading speed of some pages. It is primarily intended for cases where pages contain many
resources that are heavy in terms of size. The plugin achieves this by instructing the browser
to fetch certain resources before they are needed.

## Features
- **Resource Pre-Fetching**
    Use the time the visitors are taking to browse a page to fetch other resources,
    such as catalogue images or large scripts, in the background.

    **Example:**
    While the visitors of your site are viewing the home page, the browser may pre-load images
    from your portfolio. When the visitor then views the portfolio page, those images will
    already be pre-loaded, and the page would load faster, compared to the usual scenario.

- **Page Pre-Rendering**
    Use the time your visitors are taking to browse a page to _fetch a whole other page, all of its
    associated resources, and render it in the background__.

    **Example:**
    While the visitors are browsing your offers, render the first page of the product catalogue
    in the background. When the visitor finally browses to the catalogue, it will be near instant,
    like they opened the catalogue page in another tab, and then simply switched to it.
