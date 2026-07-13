<?php

use Composer\Script\Event;
use Composer\Util\HttpDownloader;

/**
 * One-off Composer script helper for GridPHP demo project.
 * Loaded via "classmap" autoload (see composer.json), no namespace,
 * so it can live standalone at the project root.
 *
 * NOTE: cleanup() deletes this file. Only wire cleanup() into
 * post-create-project-cmd (a one-time event), never into
 * post-install-cmd / post-update-cmd, or later `composer update`
 * runs will fail trying to call a class that no longer exists.
 */
class ComposerScript
{
    private const REMOTE_URL   = 'https://www.gridphp.com/secure/free/jqgrid_dist.phps';
    private const TARGET_PATH  = __DIR__ . '/lib/inc/jqgrid_dist.php';
    private const CONFIG_SAMPLE = __DIR__ . '/config.sample.php';
    private const CONFIG_TARGET = __DIR__ . '/config.php';

    /**
     * Fetch the (server-baked) trial core file over HTTP, using Composer's
     * own downloader so proxy/auth/TLS config already set up for Composer
     * is reused automatically.
     */
    public static function fetchCoreFile(Event $event): void
    {
        $io = $event->getIO();

        try {
            $downloader = new HttpDownloader($io, $event->getComposer()->getConfig());
            $content = $downloader->get(self::REMOTE_URL)->getBody();
        } catch (\Exception $e) {
            $io->writeError('<error>GridPHP: failed to fetch trial file - ' . $e->getMessage() . '</error>');
            exit(1);
        }

        if ($content === null || trim($content) === '') {
            $io->writeError('<error>GridPHP: trial file fetch returned empty response.</error>');
            exit(1);
        }

        $bytes = @file_put_contents(self::TARGET_PATH, $content);
        if ($bytes === false || $bytes !== strlen($content)) {
            $io->writeError('<error>GridPHP: could not write trial file to ' . self::TARGET_PATH . '</error>');
            exit(1);
        }

        @chmod(self::TARGET_PATH, 0644);
        $io->write('<info>GridPHP: trial file installed.</info>');
    }

    /**
     * Detect SQLite support, rename config.sample.php -> config.php,
     * and swap in SQLite connection placeholders.
     */
    public static function setupConfig(Event $event): void
    {
        $io = $event->getIO();

        $hasSqlite = extension_loaded('pdo_sqlite') || extension_loaded('sqlite3');
        if ($hasSqlite) {
            
          if (!file_exists(self::CONFIG_SAMPLE)) {
              $io->writeError('<error>GridPHP: ' . self::CONFIG_SAMPLE . ' not found, skipping config setup.</error>');
              return;
          }
  
          if (file_exists(self::CONFIG_TARGET)) {
              $io->write('<comment>GridPHP: config.php already exists, leaving it untouched.</comment>');
              return;
          }
  
          $contents = file_get_contents(self::CONFIG_SAMPLE);
          if ($contents === false) {
              $io->writeError('<error>GridPHP: could not read config.sample.php</error>');
              return;
          }
  
          $dbPath = dirname(__FILE__) . '/demos/sample-db/database.db';
  
          $replacements = [
              '{{dbtype}}' => 'sqlite3',
              '{{dbhost}}' => $dbPath,
              '{{dbuser}}' => '',
              '{{dbpass}}' => '',
              '{{dbname}}' => '',
          ];
  
          $contents = strtr($contents, $replacements);
  
          $bytes = @file_put_contents(self::CONFIG_TARGET, $contents);
          if ($bytes === false) {
              $io->writeError('<error>GridPHP: could not write config.php</error>');
              return;
          }
  
          @chmod(self::CONFIG_TARGET, 0644);
          $io->write('<info>GridPHP: config.php created with SQLite defaults.</info>');
        }  
    }

    /**
     * Print a success banner after `composer create-project` finishes.
     * PHP re-implementation of the shell one-liner, kept as a script method
     * so it's portable across OSes without relying on `@php -r '...'`.
     */
    public static function showSuccessBanner(Event $event): void
    {
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $fg = $isWindows ? '' : "\033[37m";
        $bg = $isWindows ? '' : "\033[44m";
        $rs = $isWindows ? '' : "\033[0m";

        $title = 'GridPHP Demos Installed Successfully!';
        $lines = [
            'To view all interactive demos locally, execute:',
            '',
            '👉  php -S localhost:8000',
            '',
            'Then open your browser and navigate to http://localhost:8000',
        ];

        $width = mb_strlen($title) + 4;
        foreach ($lines as $line) {
            $width = max($width, mb_strlen($line) + 2);
        }

        $bannerText = ' ' . $title . ' ';
        $padded = str_pad($bannerText, $width, ' ', STR_PAD_BOTH);

        echo "\n" . $fg . $bg . $padded . $rs . "\n\n";
        foreach ($lines as $line) {
            echo ' ' . $line . "\n";
        }
        echo "\n";
    }

    /**
     * Remove this helper script once initial project setup is complete.
     * Intended for post-create-project-cmd ONLY (a one-time event) —
     * do not attach to post-install-cmd/post-update-cmd, since a future
     * `composer update` would then fail looking for a deleted class.
     */
    public static function cleanup(Event $event): void
    {
        $io = $event->getIO();
        $self = __FILE__;

        if (@unlink($self)) {
            $io->write('<info>GridPHP: removed composer_script.php (setup complete).</info>');
        } else {
            $io->writeError('<comment>GridPHP: could not remove composer_script.php automatically, you can delete it manually.</comment>');
        }
    }
}
