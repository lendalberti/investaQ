sudo chown -R len:_www *
chmod -R 775 *
sudo rm -f protected/runtime/application.log*
touch protected/runtime/application.log
sudo chown _www:_www protected/runtime/application.log
