#
# REQUIRES:
#       - microServiceUrl (the URL of the LE forge microservice)
#       - site (the forge site instance)
#       - certificate (the forge certificate instance)
#

set -e

TIME=$(date +%s)

wget -O letsencrypt_script$TIME https://forge-certificates.laravel.com/le/356885/547400?env=production

bash letsencrypt_script$TIME

rm letsencrypt_script$TIME
