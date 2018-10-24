#
# REQUIRES:
#		- server (the forge server instance)
#		- db_password (random password for mysql user)
#

mysql --user="root" --password="EOsvEvAlQNFMgqR0rfnQ" -e "ALTER USER 'forge'@'192.81.134.25' IDENTIFIED BY 'TechnologyArtisans';"
mysql --user="root" --password="EOsvEvAlQNFMgqR0rfnQ" -e "ALTER USER 'forge'@'%' IDENTIFIED BY 'TechnologyArtisans';"

mysql --user="root" --password="EOsvEvAlQNFMgqR0rfnQ" -e "ALTER USER 'root'@'192.81.134.25' IDENTIFIED BY 'TechnologyArtisans';"
mysql --user="root" --password="EOsvEvAlQNFMgqR0rfnQ" -e "ALTER USER 'root'@'%' IDENTIFIED BY 'TechnologyArtisans';"
