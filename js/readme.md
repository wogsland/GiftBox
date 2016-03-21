# Sizzle.IO Front End

## Directory structure
Javascript source exists in `/js`.
Third party files that are _not_ loaded by one of our package managers for whatever reason should be dropped into
`js/vendor`. This can be considered a big "do not manipulate these files" alert.
Project tasks and task configuration lives in `/js/gulp`.

## The Application Object
`/js/Sizzle.js` is the base Application object and namespace. All other functionality hangs off this parent object.

### Events
In addition to standard DOM events, `Sizzle` will emit the following events on `document`:

* `bootstrap` - Triggered once all scripts are loaded in. This event should be considered the entry point of the front
end application.

### Components
Components are self-contained pieces of functionality that manipulate the DOM or generate events. A good example is a
custom input field, or a modal system.

### Controllers
Controllers are generally 1 per page, and are responsible for configuring Components on any given page. Easiest way to
create one of these is to use the factory method `Sizzle.Controllers.create(id, callback);`. It will ensure that your
callback is not called unless an element with the provided id is on the page at `bootstrap`.

## Configuring The Build Process
There are several `build` configurations in `/js/gulp/config.js`. Each one of these has four sections of files:

* vendor_js
* vendor_css
* js
* css

The build process concatenates all scripts and style together (vendor first), respectively, then compresses them and
writes them to `public/{type}/dist`.

As a second pass, anything in `config.minify_and_migrate` is minified _without_ concatenation then muved to `public/{type}`.

It is a goal of this project to get anything in the `minify_and_migrate` list into one of the appropriate builds.

*Never manipulate the public directory files directly.* These are your build files. If changes need to be made to a
particular file, they should be done in the source files and then rebuild. Keeping this organized appropriately will
ensure that front end code is easily traversable and scripts are generally easily identifiable.

## A matter of style
### Javascript
// TODO: PUT ESLINT INTO PROJECT, TALK ABOUT ESLINT HERE.
// ALSO TALK ABOUT OO AND STYLE IN JS.

### CSS
New css (and refactored legacy css) should follow [BEM syntax](https://css-tricks.com/bem-101/) (Block - Element - Modifier).

This is a neat way to organize your classes so that your styles are portable, you have shallow specificity, and styles
are easy to read and apply.

As a convention, at the top of each file should be a BEM map, that lays out all of the possible class variations for
this particular block. It would look something like this:

```
//  .Button
//    --disabled
//    --small
//    __label
//    __icon
```

In this example `.Button` is our block, but we can see that a button can have a `.Button__label` and a `.Button__icon`.
It can also have the modifier classes `.Button--disabled` or `.Button--small`.

## Refactoring Legacy Code
* Step one of the refactor is to separate vendor files from Sizzle files. Vendor files can be concatenated in the order
that they're loaded.
* Step two is to one by one alter sizzle files so that they can be included in a build. Legacy files are generally
written in a way that assumes that that logic will need to run immediately. By giving these scripts just a _little_ more
information, you can ensure they only run _when they need to_.
    * For javascript, the Controller factory is a good way to lock functionality down to an element. By passing a callback
    along with an HTML ID to `Sizzle.Controller.create()`, you defer execution of that method until the application sees
    an element with that ID at `bootstrap`.
    * For css, you may need to refactor the classes and the file into BEM syntax. If you just _can't_ do that, a quick way
    to ensure that it can be included is to make sure that your selectors are specific enough to stand on their own. If
    you have a script that styles a `.ClassName` element a different way than you have elsewhere in the app, Don't just
    override `.ClassName`, create a modifier class that sits _with_ `.ClassName` and style _that_.
    `.ClassName.ClassName--alternative`
