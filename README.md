# SebTech - Blog

This Magento 2 plugin adds blogging functionality to your Store.  
[![Latest Stable Version](http://poser.pugx.org/sebtech/magento-blog/v)](https://packagist.org/packages/sebtech/magento-blog) [![Total Downloads](http://poser.pugx.org/sebtech/magento-blog/downloads)](https://packagist.org/packages/sebtech/magento-blog)   
[![Latest Unstable Version](http://poser.pugx.org/sebtech/magento-blog/v/unstable)](https://packagist.org/packages/sebtech/magento-blog)   [![License](http://poser.pugx.org/sebtech/magento-blog/license)](https://packagist.org/packages/sebtech/magento-blog)

## Requirements

- Magento 2.4 (Tested 2.4.3^)
- PHP 7.4

## Features

- Still in BETA. Found a bug or need support? Create an issue.
- Creating, Deleting, Updating, Viewing of Blogs.
- Individual Blogs can be enabled/disabled.
- Full support the Magento Page Builder.
- Toggle to put link in menu and/or footer-menu.

## Installation

Run the following commands: 
1. composer require sebtech/magento-blog
2. bin/magento module:enable SebTech_Blog -c 
3. bin/magento setup:upgrade
4. bin/magento setup:di:compile

# How to use
See the backend admin:

![](Readme/img.png)

## Under configuration:

- Render Blogs 
    > Set this value to Yes to render all the available blogs the frontend and make the route available.
- Add Link In Footer
    > Set this value to yes if you want to put a link to the blogs inside your website footer.
- Add Link In Menu
  > Set this value to yes if you want to put a link to the blogs in the main menu.


## Screenshots
  
![](Readme/Page-Builder.png)   
![](Readme/Page-Builder-2.png)   
![](Readme/img_1.png)    
