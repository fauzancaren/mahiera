#!/bin/bash
set -o errexit
 
git filter-branch --tree-filter "git rm -r -f --ignore-unmatch *.psd" HEAD

rm -rf .git/refs/original/ && git reflog expire --all &&  git gc --aggressive --prune
