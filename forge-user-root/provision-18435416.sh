#
# REQUIRES:
#       - site (the forge site instance)
#

# Install Utilities

if [ -d /home/forge/test.pinsdeal.ci/storage/logs ]
then
    cat > /etc/logrotate.d/forge-test.pinsdeal.ci << EOF
/home/forge/test.pinsdeal.ci/storage/logs/*.log {
    su forge forge
    weekly
    missingok
    rotate 2
    compress
    notifempty
    create 755 forge forge
}
EOF
fi
