# silverstripe-imagelinkupgrade

## Overview

So, you have already run `MigrateFileTask` but find that you still need to do a lot of manual work for updating the broken image links in `HTMLText` and `HTMLVarchar` fields.
Afraid ignoring some places while manual checking? 
Feel frustrated when trying to find the correct image link after upgrading?
Tired of repeating yourself in such a machine-ish task?
Your assistant is here!

## Explain

Then, how will this tool help you?

In a nutshell, it will find all the places where a broken image link could be replaced with a correct link in all the `HTMLText` and `HTMLVarchar` fields of `DataObject`.

How it does the job?
Take a look at `ImageLinkUpgradeTask.php`, the overall process is:

1. Retrieve all `DataObject` classes contains HTMLText or HTMLVarchar field
2. Retrieve all image records in DB, get the mapping relation of ID, Filename and the accessible URL
3. Gather upgrade info by each class: which class, which field, what are the old links and their replacement for that field
4. Apply changes to the database

More details could be found in the code.

## How to use

Add dependency in your `composer.json`:

```javascript
...
"require-dev": {
    "zzdjk6/silverstripe-imagelinkupgrade": "^1.0"
},
...(below won't be necessary after publish to packagist.org)...
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:zzdjk6/silverstripe-imagelinkupgrade.git"
    }
],
...
```

Then just run it like other tasks: `/dev/tasks/ImageLinkUpgradeTask`

## Caveats

1. Make sure you backup your database before using this tool (it will modify your database).
2. Currently, some `DataObject` will be updated several times due to class inherit (e.g., subclasses of `SiteTree`). 
This issue won't affect the final result (just a version jump compare to the original one)
3. This tool keeps the `Status` of versioned `DataObject` in mind, which means if the `Live` version is not the same as the `Stage` version, only `Stage` version will be changed.
