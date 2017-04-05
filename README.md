# adminer-elasticsearch
The adminer-elasticsearch package provides the glue to connect Adminer to a local Elasticsearch system.

# Developer Notes
- adminer-x.y.z.php: the source file directly from Adminer
- adminer-elasticsearch.conf: the Apache configlet file
- docroot
  - index.php: standard Adminer wrapper when plugins are used
  - adminer.css: a prettier theme from Adminer
- plugins
  - elasticsearch.php: custom Elasticsearch plugin that authenticates via ClearOS / WikiSuite 
  - plugin.php: directly from Adminer - it's required for any plugin (see https://www.adminer.org/en/plugins/)
