#!/bin/bash

# --- CONFIGURATION (Relative Paths) ---
CORE_DIR=$(pwd)
COMMUNITY_DIR="../gridphp-community"

SECURE_DIST_URL="https://secure:pFfqBLLcZsymgKL36GnB@www.gridphp.com/secure/free"

echo "🚀 Starting automated clean build process..."
echo "📍 Core Directory:      $CORE_DIR"
echo "📍 Community Directory: $COMMUNITY_DIR"

# Verify the community folder actually exists one level up before destroying files
if [ ! -d "$COMMUNITY_DIR" ]; then
    echo "❌ ERROR: Cannot find community directory at $COMMUNITY_DIR"
    exit 1
fi

# 1. Clean the old community repo directory (safeguarding metadata and git internals)
cd "$COMMUNITY_DIR" || exit 1
echo "🧹 Emptying public target directory..."

# Delete top-level items only; rm -rf handles recursion. -maxdepth 1 avoids
# errors from find trying to traverse directories already removed.
find . -maxdepth 1 -name '.git' -prune -o ! -name '.' ! -name 'composer.json' ! -name 'README.md' -exec rm -rf {} +

# 2. Export ONLY the latest committed code from Core (ignores modified local files)
cd "$CORE_DIR" || exit 1
echo "📦 Exporting clean HEAD commit snapshot from Core..."
git archive HEAD | tar -x --exclude='.git' --exclude='README.md' --exclude='composer.json' -C "$COMMUNITY_DIR"
# 3. Navigate back to Community to perform deletions
cd "$COMMUNITY_DIR" || exit 1

# 4. Copy directories
# echo "📦 Copying templates from Core..."
# cp -r "$CORE_DIR/templates" "$COMMUNITY_DIR/templates"

# 5. Remove the requested source directories
echo "🗑️ Removing development src folders..."
rm -rf lib/js/jqgrid/js/src
rm -rf lib/js/jqgrid/css/src

# 6. Remove the requested un-obfuscated template source files
echo "🗑️ Stripping distribution target files..."
rm -f lib/inc/jqgrid_dist.php
rm -f lib/inc/jqgrid_dist_free.php
rm -rf tryonline
echo "" > lib/inc/ai/ai_grid.php

# 7. Download the pre-built community distribution file from secure server
echo "🔒 Downloading pre-built distribution file..."
curl -s "$SECURE_DIST_URL/jqgrid_dist.phps" > lib/inc/jqgrid_dist.php
curl -s "$SECURE_DIST_URL/ai_grid.phps" > lib/inc/ai/ai_grid.php

# Check if the download succeeded or failed blankly
if [ ! -s lib/inc/jqgrid_dist.php ]; then
    echo "❌ ERROR: Obfuscated binary file is missing or empty! Halting push."
    exit 1
fi

# 8. Git Add, Commit, and Push out natively to public GitHub repo
echo "🌐 Syncing updates directly to GitHub..."
git add .
git commit -m "Release: Community rolling build - $(date +%F)"
git push origin main

# Return the user cleanly to their core workspace directory
cd "$CORE_DIR" || exit 1
echo "✅ Script successfully finished processing!"