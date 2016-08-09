#!/usr/bin/python

# Open a file


import os

fo = open('mysql')
text = fo.readline()
while text:
    os.system(text)
    text = fo.readline()
