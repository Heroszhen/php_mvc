function wait(seconds = 0.4){
    return new Promise((resolve, reject) => {
        setTimeout(() => {
          resolve(1);
        }, seconds * 1000);
    });
}

/**
 * @param {any} ob 
 * @returns {any}
 */
function clone(ob){
    if(ob === null)return null;
    return JSON.parse(JSON.stringify(ob));
}

function copyToClipboard(value, toalert=false){
    let input = document.createElement("input");
    document.body.appendChild(input);
    input.value = value;
    input.focus();
    input.select();
    document.execCommand('copy');
    input.parentNode.removeChild(input);
    if(toalert === true)alert("Copié");
}


/**
 * @param {File} file 
 * @returns {Promise<ProgressEvent<FileReader>>}
 */
function FileToBase64(file){
    return new Promise((resolve, err) => {
        let reader = new FileReader();
        reader.onload = (e) => {
          resolve(e);
        };
        reader.readAsDataURL(file);
    });
}

/**
 * @param {File} file 
 * @returns {Blob}
 */
async function FileToBlob(file){
    let e = await FileToBase64(file);
    return new Blob([e.result],{type : file.type});
}
