<?php defined("SYSPATH") or die("No direct script access.") ?>
<div id="g-admin-g2-import" class="g-block">
  <h1> <?= t("Gallery 2 import") ?> </h1>
  <p>
    <?= t("Import your Gallery 2 users, photos, movies, comments and tags into your new Gallery 3 installation.") ?>
  </p>

  <div class="g-block-content">
    <div id="g-admin-g2-import-notes">
      <h2> <?= t("Notes") ?> </h2>
      <p>
        <?= t("The import process is a work in progress with some known issues:") ?>
      </p>
      <ul>
        <li>
          <?= t("Gallery 3 does not support per-user / per-item permissions.  <b>Review permissions after your import is done.</b>") ?>
        </li>
        <li>
          <?= t("The only supported file formats are JPG, PNG and GIF, FLV and MP4.  Other formats will be skipped.") ?>
        </li>
        <li>
          <?= t("Deactivating the <b>notification</b>, <b>search</b> and <b>exif</b> modules during your import will make it go faster.") ?>
        </li>
        <li>
          <?= t("The eAccelerator PHP performance extension is known to cause issues.  If you're using eAccelerator and having problems, please disable it while you do your import.  One way to do that is to put <code>php_value eaccelerator.enable 0</code> in gallery3/.htaccess") ?>
        </li>
      </ul>
    </div>

    <?= $form ?>

    <? if (g2_import::is_initialized()): ?>
    <div id="g-admin-g2-import-details">
      <h2> <?= t("Import") ?> </h2>
      <ul id="g-action-status" class="g-message-block">
        <li class="g-success">
          <?= t("Gallery version %version detected", array("version" => $version)) ?>
        </li>
        <? if ($g2_sizes["thumb"]["size"] && $thumb_size != $g2_sizes["thumb"]["size"]): ?>
        <li class="g-warning">
          <?= t("Your most common thumbnail size in Gallery 2 is %g2_pixels pixels, but your Gallery 3 thumbnail size is set to %g3_pixels pixels. <a href=\"%url\">Using the same value</a> will speed up your import.",
                array("g2_pixels" => $g2_sizes["thumb"]["size"],
                      "g3_pixels" => $thumb_size,
                      "url" => html::mark_clean(url::site("admin/theme_options")))) ?>
        </li>
        <? endif ?>

        <? if ($g2_sizes["resize"]["size"] && $resize_size != $g2_sizes["resize"]["size"]): ?>
        <li class="g-warning">
          <?= t("Your most common intermediate size in Gallery 2 is %g2_pixels pixels, but your Gallery 3 intermediate size is set to %g3_pixels pixels. <a href=\"%url\">Using the same value</a> will speed up your import.",
              array("g2_pixels" => $g2_sizes["resize"]["size"],
                    "g3_pixels" => $resize_size,
                    "url" => html::mark_clean(url::site("admin/theme_options")))) ?>
        </li>
        <? endif ?>
      </ul>

      <div class="g-message-block g-info">
        <p>
          <?= t("Your Gallery 2 has the following importable data in it") ?>
        </p>
        <ul>
          <li>
            <?= t2("1 user", "%count users", $g2_stats["users"]) ?>
          </li>
          <li>
            <?= t2("1 group", "%count groups", $g2_stats["groups"]) ?>
          </li>
          <li>
            <?= t2("1 album", "%count albums", $g2_stats["albums"]) ?>
          </li>
          <li>
            <?= t2("1 photo", "%count photos", $g2_stats["photos"]) ?>
          </li>
          <li>
            <?= t2("1 movie", "%count movies", $g2_stats["movies"]) ?>
          </li>
          <li>
            <?= t2("1 comment", "%count comments", $g2_stats["comments"]) ?>
          </li>
          <li>
            <?= t2("1 tagged photo/movie/album",
                "%count tagged photos/movies/albums", $g2_stats["tags"]) ?>
          </li>
        </ul>
      </div>

      <p>
        <a class="g-button g-dialog-link ui-state-default ui-corner-all"
           href="<?= url::site("admin/maintenance/start/g2_import_task::import?csrf=$csrf") ?>">
          <?= t("Begin import!") ?>
        </a>
      </p>
    </div>

    <div>
      <h2> <?= t("Migrating from Gallery 2") ?> </h2>
      <p>
        <?= t("Once your migration is complete, put this block at the top of your gallery2/.htaccess file and all Gallery 2 urls will be redirected to Gallery 3") ?>
      </p>

      <textarea rows="2">&lt;IfModule mod_rewrite.c&gt;
  Options +FollowSymLinks
  RewriteEngine On
  RewriteBase <?= html::clean(g2_import::$g2_base_url) ?>
  RewriteRule ^(.*)$ <?= url::site("g2/map?path=\$1") ?>   [QSA,L,R=301]
&lt;/IfModule&gt;</textarea>
    </div>
    <? endif ?>
  </div>
</div>
