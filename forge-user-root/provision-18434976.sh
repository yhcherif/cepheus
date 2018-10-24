#
# REQUIRES:
#       - job (the forge job instance)
#

echo "" | tee -a /etc/crontab
echo "# Laravel Forge Scheduler 276568" | tee -a /etc/crontab
echo '0 0 * * * root /usr/local/bin/composer self-update > /home/forge/.forge/scheduled-276568.log 2>&1' | tee -a /etc/crontab
