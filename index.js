class Index {

    path = ""

    async main() {

        //call api list files form path
        await this.fetchFilesFromPath().then(res =>
            this.renderFilesList(res.message)
        )

        //Register interection events
        this.registerEvents()
    }

    async fetchFilesFromPath() {
        let options = {
            method: 'GET',
            headers: {}
        };

        const response = await fetch("http://localhost/index.php", options);
        return await response.json();
    }

    renderFilesList(files) {

        var listHtml = '';
        for (let i = 0; i < files.length; i++) {
            listHtml += `<li class='file' id='${i}' name-file='${files[i]}'>${files[i]}</li>`
        }

        document.getElementById("filesList").insertAdjacentHTML('afterbegin', listHtml)
    }

    async fetchFileDownload(file) {
        let options = {
            method: 'POST',
            headers: {}
        };

        const response = await fetch(`http://localhost/index.php?file=${file}`, options);
        return await response.json();
    }



    //Interection events
    registerEvents() {
        //Files List click function
        const filesList = document.getElementById('filesList')
        filesList.addEventListener("click", e => this.fetchFileDownload(e.target.getAttribute("name-file")))

    }
}

//Start
const index = new Index()
index.main()