#!/bin/bash


sudo chmod -R a+rw web/sites/default
rm web/sites/default/settings.php

#vendor/bin/drush site:install -y --account-pass=admin --db-url=mysql://root:root@mariadb/laradrupal --site-name="NIDC"
vendor/bin/drush site:install -y --account-pass=admin --db-url=mysql://root:root@127.0.0.1:8889/triplet --site-name="NIDC"

chmod -R a+rw web/sites/default
echo "ini_set('memory_limit', -1);" >> web/sites/default/settings.php
vendor/bin/drupal site:mode dev

vendor/bin/drush en -y adminimal_admin_toolbar \
  coffee \
  commerce \
  config_translation \
  config_update_ui \
  memcache \
  memcache_admin \
  vmi

vendor/bin/drush en -y idcp_core   \
  items \
  translation
#  entity_plus \
#  user_plus \
#  neibers_idc \
#  neibers_mall \
#  neibers_translation \
#
#chmod -R a+rw web/sites/default/settings.php
#echo "\$settings['file_private_path'] = 'private';" >> web/sites/default/settings.php
#echo 'include $app_root . "/" . $site_path . "/settings.local.php";' >> web/sites/default/settings.php

# Initial demo data.
#vendor/bin/drush mim ip_xls
#vendor/bin/drush mim product_xls
#
#bin/drupal locale:language:add zh-hans
#
#vendor/bin/drush cset -y language.negotiation url.prefixes.en "en"
#vendor/bin/drush cset -y language.types negotiation.language_interface.enabled.language-browser 0
#
#vendor/bin/drush cset -y system.site default_langcode "zh-hans"
#vendor/bin/drush locale:update

vendor/bin/drupal thi -y smarts
vendor/bin/drush cset -y system.theme admin smarts
vendor/bin/drush cset -y system.theme default smarts
