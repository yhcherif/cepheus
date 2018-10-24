#
# REQUIRES:
#       - name (the name of the SSH Key)
#		- key (the key text)
#

echo "# Mackbook" | tee -a /home/forge/.ssh/authorized_keys
echo "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQClTBiC9w/KZeEq4jkkyw1Rv/VivvbTKyPUwsAYIE2eBfGB4fMiyfPNeO6ehuF4y1WVBWGPNBf5FGnAgQPWVlBm62iRBdg5FP/5gAXYKOA+KUC19okFYyr04MNhjl3Y2X2AIPENMNob6UxEly+pPIA+nBsL4VMpWOp2QjHunZYFXS5rkgXwxhEeE9dArRHnRS3aG5PWJ5HX2kypYGJGLjjrL39MfP+8mDr37+M+/X1pCOtKO2w89OTTomODRMGVmy9G+zEWpX9b1QrXxWo1x1JEsDzIg49RdOC4JMgD5Bj+VfARBcIG/zMaxyBDUjzI3KvHlT8jpswM3DCSvLo66wXB youssouf.cherif.hamed@gmail.com
" | tee -a /home/forge/.ssh/authorized_keys
