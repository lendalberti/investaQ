sudo chown -R len:apache *
chmod -R 775 *
sudo rm -f protected/runtime/application.log*
touch protected/runtime/application.log
sudo chown apache:apache protected/runtime/application.log
