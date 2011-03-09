*******************
Optimizing Galleria
*******************

One of the goals with Galleria is to simplify the process of creating beautiful image galleries on the web. We did that; setting up a gallery is really easy and most of the times it ”just works” with almost any images. However, there are some things you can do to make the Gallery run even smoother, especially when deploying.

1. Use reasonably sized images
------------------------------

The biggest performance lag comes from using really large images and letting Galleria scale them down for you. This might work OK in your local environment, but it can have great effects for users with less optimized setups. Always scale down your images to a reasonable size and use jpg for compression. A good standard to start with is 1000px x 1000px using 70 as quality.


2. Use separate thumbnails
--------------------------

Galleria can create thumbnails for you. This is great for setting up a Gallery and trying out different themes without having to manually scale images. But when deploying, you will always get the best result if you scale your images to a size that is close to the display size, either manually or using server-side scripting. This is especially true for thumbnails. If you let Galleria create thumbnails, it will load all full-sized images at once. If you use separate thumbnails, it will load them first and then just load the big image when needed. This can improve the overall user experience.

You can define separate thumbnails by linking a thumbnail to the big image in the HTML source or using a plain JSON object as gallery data. See the Quick Guide for more info and examples.


3. Don’t add too many images at once
------------------------------------

There are no limits to how many images you can add, but after 30 it can clog the pipes on load, especially in IE. Use a reasonable amount of images at first, then try the ``.load()``, ``.splice()`` and ``.push()`` methods to add/remove image data on the fly.


4. Include your theme js in the head
------------------------------------

We generally recommend you to use the ``Galleria.loadTheme`` method to load themes because it’s really convenient and makes it easier to switch themes. However, you might get a snappier result if you include the theme javascript in the head tag, especially if it’s minified together with the rest of your scripts.

You can also add the theme CSS file as a ``<link>`` tag to make it load faster. Just make sure you give it the id 'galleria-theme'.


5. Use JSON as data
-------------------

This can also be a small speed-booster, but can also be negative from a progressive enhancement point of view. If you use JSON, make sure you serve a reasonable fallback for users without JavaScript turned on. Read more in the Quick Guide for more examples.


