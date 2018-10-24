#
# REQUIRES:
#		- site (the forge site instance)
#

# Write A Dummy PHP Info Stub To A Site

rm -rf /home/forge/default/public
mkdir -p /home/forge/default/public


# Deploy The Proper Stub File Based On Project Type

echo "<?php phpinfo();" > /home/forge/default/public/index.php
