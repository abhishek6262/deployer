#!/usr/bin/env bash

if [ ! -d ~/.nvm ]; then
    touch ~/.bash_profile
    curl https://raw.githubusercontent.com/creationix/nvm/v0.34.0/install.sh | bash
    source ~/.nvm/nvm.sh
    source ~/.profile
    source ~/.bashrc
    nvm install node
    nvm use node
fi