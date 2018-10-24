#
# REQUIRES:
#		- site (the forge site instance)
#

# Write A Dummy PHP Info Stub To A Site

rm -rf /home/forge/beta.pinsdeal.ci/public
mkdir -p /home/forge/beta.pinsdeal.ci/public


# Deploy The Proper Stub File Based On Project Type

echo "<?php phpinfo();" > /home/forge/beta.pinsdeal.ci/public/index.php
