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
    private const FILES_TO_FETCH = [
        'https://www.gridphp.com/secure/free/jqgrid_dist.phps' => __DIR__ . '/lib/inc/jqgrid_dist.php',
        'https://www.gridphp.com/secure/free/jqgrid_ai.phps'     => __DIR__ . '/lib/inc/jqgrid_ai.php',
    ];
    
    private const CONFIG_SAMPLE = __DIR__ . '/config.sample.php';
    private const CONFIG_TARGET = __DIR__ . '/config.php';

    /**
     * Fetch all registered remote files over HTTP using Composer's Downloader.
     */
    public static function fetchCoreFiles(Event $event): void
    {
        $io = $event->getIO();

        try {
            $downloader = new HttpDownloader($io, $event->getComposer()->getConfig());
        } catch (\Exception $e) {
            $io->writeError('<error>GridPHP: failed to initialize downloader - ' . $e->getMessage() . '</error>');
            exit(1);
        }

        foreach (self::FILES_TO_FETCH as $remoteUrl => $targetPath) {

            try {
                $content = $downloader->get($remoteUrl)->getBody();
            } catch (\Exception $e) {
                $io->writeError("<error>GridPHP: failed to fetch file from $remoteUrl - " . $e->getMessage() . "</error>");
                exit(1);
            }

            if ($content === null || trim($content) === '') {
                $io->writeError("<error>GridPHP: empty response returned from $remoteUrl</error>");
                exit(1);
            }

            // Ensure destination directory structure exists (e.g., /lib/inc/)
            $directory = dirname($targetPath);
            if (!is_dir($directory)) {
                if (!@mkdir($directory, 0755, true) && !is_dir($directory)) {
                    $io->writeError("<error>GridPHP: failed to create directory: $directory</error>");
                    return;
                }
            }

            // Write content to target file
            $bytes = @file_put_contents($targetPath, $content);
            if ($bytes === false || $bytes !== strlen($content)) {
                $io->writeError("<error>GridPHP: could not write file to $targetPath</error>");
                return;
            }

            @chmod($targetPath, 0644);
        }
        
        $io->write("<info>GridPHP: core libs successfully installed.</info>");
    }

    /**
     * Give the sample-db folder + file write access so the web server
     * (whatever user it runs as) can create/write the SQLite database.
     */
    public static function fixDbPermissions($io): void
    {
        $dbDir  = __DIR__ . '/demos/sample-db';
        $dbFile = $dbDir . '/database.db';
 
        if (!is_dir($dbDir)) {
            $io->writeError('<error>GridPHP: ' . $dbDir . ' does not exist, skipping permission fix.</error>');
            return;
        }
 
        @chmod($dbDir, 0777);
        if (file_exists($dbFile)) {
            @chmod($dbFile, 0666);
        }
 
        $io->write('<info>GridPHP: demos/sample-db permissions set for write access.</info>');
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
  
          $replacements = [
              '{{dbtype}}' => 'sqlite3',
              '"{{dbhost}}"' => "dirname(__FILE__).'/demos/sample-db/database.db'",
              '{{dbuser}}' => '',
              '{{dbpass}}' => '',
              '{{dbname}}' => '',
              '{{apikey}}' => '',
          ];
  
          $contents = strtr($contents, $replacements);
  
          $bytes = @file_put_contents(self::CONFIG_TARGET, $contents);
          if ($bytes === false) {
              $io->writeError('<error>GridPHP: could not write config.php</error>');
              return;
          }
  
          @chmod(self::CONFIG_TARGET, 0644);
          $io->write('<info>GridPHP: config.php created with SQLite defaults.</info>');

          // fix db permissions
          self::fixDbPermissions($io);
        }  
    }

    /**
     * Print a success banner after `composer create-project` finishes.
     * PHP re-implementation of the shell one-liner, kept as a script method
     * so it's portable across OSes without relying on `@php -r '...'`.
     */
    public static function showSuccessBanner(Event $event): void
    {
        $fg = "\033[37m";
        $bg = "\033[44m";
        $rs = "\033[0m";

        $blue = "\033[34m";
        $reset = "\033[0m";
        $title = 'GridPHP + Demos installed successfully!';
        
        $width = strlen($title) + 8;
        $paddedTitle = str_pad(' ' . $title . ' ', $width, ' ', STR_PAD_BOTH);

        $lines = [
            '',
            'To view all interactive demos locally, execute:',
            '',
            '👉  php -S localhost:8000',
            '',
            'Then open your browser and navigate to http://localhost:8000',
            "",
            "New to GridPHP? Check out our documentation.",
            "",
            "Build something amazing!",
        ];

        echo "\n " . $fg . $bg . $paddedTitle . $rs . "\n\n";
        echo " ┌ {$blue}Application ready{$reset} ───────────────────────────────────────────┐\n";
        foreach ($lines as $line) {
            $paddedLine = str_pad($line, 61);
            if (strpos($paddedLine, 'documentation') !== false) {
                // Add terminal hyperlink for "documentation" with blue and underline ANSI codes
                $paddedLine = str_replace(
                    'documentation',
                    "\033]8;;https://gridphp.com/docs\033\\\033[34;4mdocumentation\033[0m\033]8;;\033\\",
                    $paddedLine
                );
            }
            echo " │ " . $paddedLine . "│\n";
        }
        echo " └──────────────────────────────────────────────────────────────┘\n";
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
