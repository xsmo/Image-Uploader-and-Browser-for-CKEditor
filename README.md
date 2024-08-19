# Image Uploader and Browser for CKEditor
[Image Uploader and Browser for CKEditor](https://imagebrowser.maleck.org/index.php) is a plugin that allows you to **upload images** easily to your server and add automatically to CKEditor. Since **version 2.0** you can **browse and manage** your uploaded files online right in your browser - without using a FTP Client. The Image Browser is **responsive** and looks great on every device width.

---

![#f03c15](https://placehold.co/15x15/f03c15/f03c15.png)![#f03c15](https://placehold.co/15x15/f03c15/f03c15.png)![#f03c15](https://placehold.co/15x15/f03c15/f03c15.png)![#f03c15](https://placehold.co/15x15/f03c15/f03c15.png)![#f03c15](https://placehold.co/15x15/f03c15/f03c15.png)![#f03c15](https://placehold.co/15x15/f03c15/f03c15.png) 
**Please note: This project is discontinued and no longer maintained.**
![#f03c15](https://placehold.co/15x15/f03c15/f03c15.png)![#f03c15](https://placehold.co/15x15/f03c15/f03c15.png)![#f03c15](https://placehold.co/15x15/f03c15/f03c15.png)![#f03c15](https://placehold.co/15x15/f03c15/f03c15.png)![#f03c15](https://placehold.co/15x15/f03c15/f03c15.png)![#f03c15](https://placehold.co/15x15/f03c15/f03c15.png) 

---

## Download
You can download the Image Uploader and Browser for CKEditor [here](http://ckeditor.com/addon/imageuploader).

## Features
* Functionality: Upload, delete, download and view your PNG, JPG & GIF files.
* Secure: Only you can access the image browser by a password protection since version 4.0.
* Flexible: Do you already have your own upload folder? You can easily switch and create folders in the image browser.
* Modern UI: The Image Browser is responsive and looks great on every device width.
* Support: Regular updates and an always up to date documentation make it easy for you to install and use the browser.

## Installation and Configuration
First extract the downloaded file into the CKEditor’s *plugins* folder. Then enable the plugin by changing or adding the extraPlugins line in your configuration (config.js):

### Defining Configuration In-Page
```
CKEDITOR.replace( 'editor1', {
  extraPlugins: 'imageuploader'
});
```

### Using the config.js File
```
CKEDITOR.editorConfig = function( config ) {
  config.extraPlugins = 'imageuploader';
};
```

Don't forget to set `CHMOD writable permission (755)` to the **imageuploader** folder on your server.

## How to use

### Browse and manage files
Open the **Image info** tab and click **Browse server**. A new window will open where you see all your uploaded images. Open the preview of a picture by tapping on the image. To use the file click **Use**. To upload a new image open the upload panel in the image browser.

### Change the upload path
Open the **Image info** tab and click Browse server. A new window will open where you see all your uploaded images. Open the **Settings** to choose another upload path.

### Further questions?
Please refer to the [plugin documentation](https://imagebrowser.maleck.org/index.php).

## License
Image Uploader and Browser for CKEditor is licensed under the MIT license:
[http://en.wikipedia.org/wiki/MIT_License](http://en.wikipedia.org/wiki/MIT_License)

Copyright © 2015-2024 by Moritz Maleck
