#!/bin/bash

# git clone でソースはダウンロードしたものとする
BASE=$(cd $(dirname $0); cd ../; pwd)

SYMLINK_DIR=${HOME}/public_html
FILE_DATA_SRC_DIR=web/api/Bank/Data

ENTRY_POINT_NAME=mar

# filename: getopts-2.sh
while getopts "s:d:e:" opts
do
    case $opts in
        s)
            # symlinkを貼る先
            SYMLINK_DIR=$OPTARG
            ;;
        d)
            # FILEのデータを置く先
            FILE_DATA_SRC_DIR=$OPTARG
            ;;
        e)
            # Entry point name
            ENTRY_POINT_NAME=$OPTARG
            ;;
    esac
done

# ~/public_html/ 以下にsymlink
if [ ! -e ${SYMLINK_DIR}/${ENTRY_POINT_NAME} ]; then
    echo "ln -s ${BASE}/web/ ${SYMLINK_DIR}/${ENTRY_POINT_NAME}"
    ln -s ${BASE}/web/ ${SYMLINK_DIR}/${ENTRY_POINT_NAME}
fi

# web/api/Bank/Data を作成
if [ ! -e ${FILE_DATA_SRC_DIR} ]; then
    echo "mdkir ${FILE_DATA_SRC_DIR}"
    mkdir $BASE/${FILE_DATA_SRC_DIR}
fi

