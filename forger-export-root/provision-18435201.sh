#
# REQUIRES:
#       - server (the server instance)
#       - user (the database user instance)
#

# Add MySQL User

mysql --user="root" --password="TechnologyArtisans" -e "DROP USER IF EXISTS wordpress;"
mysql --user="root" --password="TechnologyArtisans" -e "CREATE USER IF NOT EXISTS 'wordpress'@'192.81.134.25' IDENTIFIED BY 'wordpress';"

mysql --user="root" --password="TechnologyArtisans" -e "GRANT ALL ON wordpress.* TO 'wordpress'@'192.81.134.25' IDENTIFIED BY 'wordpress';"
mysql --user="root" --password="TechnologyArtisans" -e "GRANT ALL ON wordpress.* TO 'wordpress'@'%' IDENTIFIED BY 'wordpress';"

mysql --user="root" --password="TechnologyArtisans" -e "FLUSH PRIVILEGES;"
