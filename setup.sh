docker build -t hakoeve/xampp ./xampp/

if [ ! -e hakoeve ]; then
    git clone -b environment https://github.com/HakoEve/hakoeve.git
    chmod -R 777 hakoeve/app/tmp
    chmod -R 777 hakoeve/app/Config
fi