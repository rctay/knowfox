Some aspects of Knowfox use configurable options. Among these are 

* the list of available concept types
* forward and backward titles of relationships  

Configuration is merged from three places:

* The file config/knowfox.php
* Packages, e.g. the package `knowfox/entangle`
* the `data` field of a user-specific top-level concept titled `Configuration`. This field is formated as a [YAML](http://yaml.org/) object.

If you want to seed your relationships with some entries, add a toplevel concept `Configuration`. 
Then, add an entry `relationships` as settings data.

Here is _my_ list:

````
relationships:
  commission: [ 'commissions', 'commissioned by' ]
  describes: [ 'describes', 'described by' ]
  founded: [ 'founded', 'founded by' ]
  input: [ 'gave input for', 'git input from' ]
  invented: [ 'has invented', 'invented by' ]
  involved: [ 'works on', 'being worked on by' ]
  mentions: [ 'mentions', 'mentioned at' ]
  met: [ 'met at', 'met here' ]
  operates: [ 'operates', 'operated by' ]
  platform: [ 'provides platform for', 'uses platform by' ]
  recommends: [ 'recommends', 'recommended by' ]
  replaces: [ 'replaces', 'replaced by' ]
  similar: [ 'similar to', 'similar to' ]
  supports: [ 'supports', 'supported by' ]
  teacher: [ 'teacher of', 'pupil of' ]
  timeline: [ 'has timeline', 'timeline of' ]
  translates: [ 'translates', 'translated' ]
  uses: ['uses', 'used by']
  works_at: ['works at', 'has employee']
  written: [ 'has written', 'written by' ]
  plugin: [ 'plugin for', 'supports plugin' ]
````
