api = 2
core = 7

projects[drupal][type] = "core"
projects[drupal][patch][] = "https://www.drupal.org/files/issues/1358896-hook-image-style-path-alter.patch" 
projects[drupal][patch][] = "https://www.drupal.org/files/issues/2479523.1-normalize-alter-hook.patch"

;projects[media][patch][] = "https://www.drupal.org/files/issues/2479473.5-upload-params.patch"
;projects[file_entity][patch][] = "https://www.drupal.org/files/issues/2479483.2-uri-alter.patch"
;projects[file_entity][patch][] = "https://www.drupal.org/files/issues/2482757.1-file-normalize.patch"
;projects[imagemagick][patch][] = "https://www.drupal.org/files/issues/imagemagick-1695068-14.patch"

projects[amazons3][type] = "module"
projects[amazons3][download][type] = "git"
projects[amazons3][download][url] = "http://github.com/GetValkyrie/drupal_amazons3.git"
projects[amazons3][download][branch] = "vendor"
