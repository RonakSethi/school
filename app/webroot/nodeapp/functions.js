 // configs
var CONFIG = require("./config.js");
// node modules
fs = require('fs-extra');
module.exports.saveFile = saveFile;
module.exports.saveVideoFile = saveVideoFile;
module.exports.notificationSettingIns = notificationSettingIns;
module.exports.random_code = random_code;
module.exports.saveFileCover = saveFileCover;
module.exports.moveFile = moveFile;
module.exports.deleteFolderRecursive = deleteFolderRecursive;
module.exports.rmdirAsync = rmdirAsync;
module.exports.saveFileWithCallback = saveFileWithCallback;
module.exports.saveFileWithCallbackalbum = saveFileWithCallbackalbum;
// general functions start

function saveFileCover(fileData, fileName, sub_folder) {
    var filePath = CONFIG.imageFilePath + sub_folder + '/' + fileName;
    var dirName = CONFIG.imageFilePath + sub_folder + '/';
    console.log("err!! image is not shown");
    if (fileData != '') {
        if (!fs.existsSync(dirName)) {
            fs.mkdirSync(dirName, 0777, function (err) {
                if (err) {
                    console.log("err!! image is not shown");
                    console.log(err);
                    resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '"}\n';
                    callback(400, null, resultJson);
                    return;
                }
            });
        }

        fs.chmod(dirName, 511);
        fs.writeFile(filePath, fileData, 'base64', function (err) {
            if (err) {
                console.log('Image not uploaded Error is: ', err);
                return false;
            } else {
                var stats = fs.statSync(filePath);
                var fileSizeInBytes = stats["size"]

                return fileSizeInBytes;
            }
        });
    } else {
        return true;
    }
}

function saveFile(fileData, fileName, sub_folder) {
    var filePath = CONFIG.imageFilePath + sub_folder + '/' + fileName;
    console.log(filePath);
    var dirName = CONFIG.imageFilePath + sub_folder + '/';
    console.log(dirName);
  console.log("err!! image is not shown");
    if (fileData != '') {
        if (!fs.existsSync(dirName)) {
            fs.mkdirSync(dirName, 0777, function (err) {
                if (err) {
                    console.log("err!! image is not shown");
                    console.log(err);
                    resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '"}\n';
                    callback(400, null, resultJson);
                    return;
                }
            });
        }
        //fs.chmod(dirName, 777);
        fs.writeFile(filePath, fileData, 'base64', function (err) {
            if (err) {
                console.log('Image not uploaded Error is: ', err);
                return false;
            } else {
                return true;
            }
        });
    } else {
        return true;
    }
}

function saveFileWithCallback(fileData, fileName, sub_folder, directoryName,callback) {
    var dirName = CONFIG.imageFilePath + "tributes/" + directoryName + '/';
    var dirSubFolderName = dirName + sub_folder + '/';
    console.log(dirName);
    var filePath = dirSubFolderName + fileName;
    if (fileData != '') {
        if (!fs.existsSync(dirName)) {
            fs.mkdirSync(dirName, 0777, function (err) {
                if (err) {
                    console.log("err!! image is not shown");
                    console.log(err);
                    resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '"}\n';
                    callback(400, null, resultJson);
                    return;
                }
            });
        }
        if (!fs.existsSync(dirSubFolderName)) {
            fs.mkdirSync(dirSubFolderName, 0777, function (err) {
                if (err) {
                    console.log("err!! image is not shown");
                    console.log(err);
                    resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '"}\n';
                    callback(400, null, resultJson);
                    return;
                }
            })
        }
        //fs.chmod(dirName, 777);

        fs.writeFile(filePath, fileData, 'base64', function (err) {
            var stats = fs.statSync(filePath)
    var fileSizeInBytes = stats["size"]
    callback(fileSizeInBytes);
    return;
    
            if (err) {
                console.log('Image not uploaded Error is: ', err);
                return false;
            } else {
                return true;
            }
        });
    } else {
        return true;
    }
}

function saveFileWithCallbackalbum(fileData, fileName, sub_folder, directoryName,callback) {
   
    var dirName = CONFIG.imageFilePath + directoryName + '/';
    var dirSubFolderName = dirName + sub_folder + '/';
    console.log(dirName);
    var filePath = dirSubFolderName + fileName;
    if (fileData != '') {
        if (!fs.existsSync(dirName)) {
            fs.mkdirSync(dirName, 0777, function (err) {
                if (err) {
                    console.log("err!! image is not shown");
                    console.log(err);
                    resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '"}\n';
                    callback(400, null, resultJson);
                    return;
                }
            });
        }
        if (!fs.existsSync(dirSubFolderName)) {
            fs.mkdirSync(dirSubFolderName, 0777, function (err) {
                if (err) {
                    console.log("err!! image is not shown");
                    console.log(err);
                    resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '"}\n';
                    callback(400, null, resultJson);
                    return;
                }
            })
        }
        //fs.chmod(dirName, 777);

        fs.writeFile(filePath, fileData, 'base64', function (err) {
            var stats = fs.statSync(filePath)
    var fileSizeInBytes = stats["size"]
    callback(fileSizeInBytes);
    return;
    
            if (err) {
                console.log('Image not uploaded Error is: ', err);
                return false;
            } else {
                return true;
            }
        });
    } else {
        return true;
    }
}
function saveVideoFile(fileData, fileName, sub_folder) {
    var filePath = CONFIG.imageFilePath + sub_folder + '/' + fileName + '.mov';
    var dirName = CONFIG.imageFilePath + sub_folder + '/';
    console.log("err!! image is not shown");
    if (fileData != '') {
        if (!fs.existsSync(dirName)) {
            fs.mkdirSync(dirName, 0777, function (err) {
                if (err) {
                    console.log(err);
                    resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '"}\n';
                    callback(400, null, resultJson);
                    return;
                }
            });
        }
        fs.writeFile(filePath, fileData, 'base64', function (err) {
            if (err) {
                console.log('Image not uploaded Error is: ', err);
                return false;
            } else {
                return true;
            }
        });
    } else {
        return true;
    }
}

function saveAudioFile(fileData, fileName, sub_folder) {
    var filePath = CONFIG.imageFilePath + sub_folder + '/' + fileName + '.mp3';
    var dirName = CONFIG.imageFilePath + sub_folder + '/';
    console.log("err!! image is not shown");
    if (fileData != '') {
        if (!fs.existsSync(dirName)) {
            fs.mkdirSync(dirName, 0777, function (err) {
                if (err) {
                    console.log(err);
                    resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '"}\n';
                    callback(400, null, resultJson);
                    return;
                }
            });
        }
        fs.writeFile(filePath, fileData, 'base64', function (err) {
            if (err) {
                console.log('Image not uploaded Error is: ', err);
                return false;
            } else {
                return true;
            }
        });
    } else {
        return true;
    }
}

function savePdfFile(fileData, fileName, sub_folder) {
    var filePath = CONFIG.imageFilePath + sub_folder + '/' + fileName + '.pdf';
    var dirName = CONFIG.imageFilePath + sub_folder + '/';
    console.log("err!! image is not shown");
    if (fileData != '') {
        if (!fs.existsSync(dirName)) {
            fs.mkdirSync(dirName, 0777, function (err) {
                if (err) {
                    console.log(err);
                    resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '"}\n';
                    callback(400, null, resultJson);
                    return;
                }
            });
        }
        fs.writeFile(filePath, fileData, 'base64', function (err) {
            if (err) {
                console.log('Image not uploaded Error is: ', err);
                return false;
            } else {
                return true;
            }
        });
    } else {
        return true;
    }
}

// insert notifications setting 
// insert push setting

function notificationSettingIns(userID, connection) {
    var user_id = 0;
    if (userID) {
        user_id = userID;
    }
    connection.query('SELECT id  FROM `notification_settings` where user_id="' + user_id + '"', function (err, results) {
        if (!err)
        {
            var pagingCount = results.length;
            var restData = [];

            if (pagingCount == 0)
            {
                connection.query('SELECT id  FROM `notifications` ', function (err, resultsPush) {
                    if (!err)
                    {

                        resultsPush.forEach(function (row) {

                            connection.query("INSERT INTO notification_settings	set user_id='" + user_id + "',notification_id='" + row.id + "',created=now() , modified=now() ");
                        });
                    }
                });
            }
        }
    });
}

function base64_encode(data) {
    var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
            ac = 0,
            enc = '',
            tmp_arr = [];
    if (!data) {
        return data;
    }

    do { // pack three octets into four hexets
        o1 = data.charCodeAt(i++);
        o2 = data.charCodeAt(i++);
        o3 = data.charCodeAt(i++);
        bits = o1 << 16 | o2 << 8 | o3;
        h1 = bits >> 18 & 0x3f;
        h2 = bits >> 12 & 0x3f;
        h3 = bits >> 6 & 0x3f;
        h4 = bits & 0x3f;
        // use hexets to index into b64, and append result to encoded string
        tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
    } while (i < data.length);
    enc = tmp_arr.join('');
    var r = data.length % 3;
    return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
}

function base64_decode(data) {

    var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
            ac = 0,
            dec = '',
            tmp_arr = [];
    if (!data) {
        return data;
    }

    data += '';
    do { // unpack four hexets into three octets using index points in b64
        h1 = b64.indexOf(data.charAt(i++));
        h2 = b64.indexOf(data.charAt(i++));
        h3 = b64.indexOf(data.charAt(i++));
        h4 = b64.indexOf(data.charAt(i++));
        bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;
        o1 = bits >> 16 & 0xff;
        o2 = bits >> 8 & 0xff;
        o3 = bits & 0xff;
        if (h3 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1);
        } else if (h4 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1, o2);
        } else {
            tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
        }
    } while (i < data.length);
    dec = tmp_arr.join('');
    return dec.replace(/\0+$/, '');
}


function random_code() {
    var pin_no = "";
    var randString = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for (var i = 0; i < 4; i++)
        pin_no += randString.charAt(Math.floor(Math.random() * randString.length));
    pin_no = "1234"
    return pin_no;
}


function getFilesizeInBytes(filename) {
    var stats = fs.statSync(filename)
    var fileSizeInBytes = stats["size"]
    return fileSizeInBytes
}


function moveFile(oldPath, newPath, callback) {
    fs.rename(oldPath, newPath, function (err) {
        if (err) {
            if (err.code === 'EXDEV') {
                var readStream = fs.createReadStream(oldPath);
                var writeStream = fs.createWriteStream(newPath);
                readStream.on('error', callback);
                writeStream.on('error', callback);
                readStream.on('close', function () {
                    fs.unlink(oldPath, callback);
                });
                readStream.pipe(writeStream);
            } else {
                callback(err);
            }
            return;
        }
        callback(err);
    });
}

function deleteFolderRecursive(path) {
  if( fs.existsSync(path) ) {
    fs.readdirSync(path).forEach(function(file,index){
      var curPath = path + "/" + file;
      if(fs.lstatSync(curPath).isDirectory()) { // recurse
        deleteFolderRecursive(curPath);
      } else { // delete file
        fs.unlinkSync(curPath);
      }
    });
    fs.rmdirSync(path);
  }
};


function rmdirAsync(path, callback) {
	fs.readdir(path, function(err, files) {
		if(err) {
			// Pass the error on to callback
			callback(err, []);
			return;
		}
		var wait = files.length,
			count = 0,
			folderDone = function(err) {
			count++;
			// If we cleaned out all the files, continue
			if( count >= wait || err) {
				fs.rmdir(path,callback);
			}
		};
		// Empty directory to bail early
		if(!wait) {
			folderDone();
			return;
		}
		
		// Remove one or more trailing slash to keep from doubling up
		path = path.replace(/\/+$/,"");
		files.forEach(function(file) {
			var curPath = path + "/" + file;
			fs.lstat(curPath, function(err, stats) {
				if( err ) {
					callback(err, []);
					return;
				}
				if( stats.isDirectory() ) {
					rmdirAsync(curPath, folderDone);
				} else {
					fs.unlink(curPath, folderDone);
				}
			});
		});
	});
};



function removeSelectedFiles(imageArray,dirpath,callback){
    var numberOfImages = imageArray.length
     fs.existsSync(dirpath, function(err, files){
        if(!err){
            
        }else{
         callback(err, []);
	return;   
        }
    });
}

