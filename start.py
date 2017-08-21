#!/usr/bin/python
# build_native.py
# Build native codes
# 
# Please use cocos console instead


import sys
import os, os.path
import shutil
import urllib
import webbrowser

from optparse import OptionParser

os.system('cls')
current_dir = os.path.dirname(os.path.realpath(__file__))
command = 'php artisan serve'
print command
webbrowser.open('http://127.0.0.1:8000')
os.system(command)

