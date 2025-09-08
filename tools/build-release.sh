#!/usr/bin/env bash
set -euo pipefail

PLUGIN_SLUG="bypierofracasso-woocommerce-emails"
BUILD_DIR="build/${PLUGIN_SLUG}"
ZIP_FILE="${PLUGIN_SLUG}.zip"

rm -rf build "${ZIP_FILE}"
mkdir -p "${BUILD_DIR}"

composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader
composer dump-autoload -o --classmap-authoritative

if [ ! -f vendor/autoload.php ]; then
  echo "vendor/autoload.php missing" >&2
  exit 1
fi

cp -R bypierofracasso-woocommerce-emails.php includes templates languages vendor README.md CHANGELOG.md "${BUILD_DIR}" 2>/dev/null
[ -f readme.txt ] && cp readme.txt "${BUILD_DIR}/"

find "${BUILD_DIR}" -name '.DS_Store' -type f -delete

( cd build && zip -r "../${ZIP_FILE}" "${PLUGIN_SLUG}" )

echo "Release package created: ${ZIP_FILE}"
