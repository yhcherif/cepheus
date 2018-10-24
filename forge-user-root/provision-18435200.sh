#
# REQUIRES:
#       - server (the server instance)
#       - database (the database instance)
#

# Create The MySQL Database

mysql --user="root" --password="TechnologyArtisans" -e "CREATE DATABASE wordpress CHARACTER SET utf8 COLLATE utf8_unicode_ci;"
