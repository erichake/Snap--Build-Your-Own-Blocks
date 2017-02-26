WorldMorph.prototype.isDocShare = false;

WorldMorph.prototype.setDocShare = function(_params) {
    var saveBtn,
        mySelf = this,
        ide = world.children[0],
        lang = navigator.language || navigator.userLanguage;

    lang = lang.split("-")[0].toLowerCase(); // To avoid mixed languages "fr-FR" (Safari)    
    this.docShareApp = _params.app;
    this.docShareFileID = _params.id;
    this.docShareFile = _params.file;
    this.isDocShare = (this.docShareApp !== "");



    ide.setLanguage(lang, function() {
        if (mySelf.docShareFile !== "") {
            ide.openProjectString(decodeURIComponent(escape(window.atob(mySelf.docShareFile))));
            if (mySelf.docShareApp !== "") {
                saveBtn = new PushButtonMorph(
                    mySelf,
                    saveToDocShare,
                    localize('Save')
                );
                saveBtn.padding = 0;
                saveBtn.fontSize = 14;
                saveBtn.corner = 5;
                saveBtn.color = new Color(137, 211, 255);
                saveBtn.highlightColor = saveBtn.color.darker();
                saveBtn.pressColor = saveBtn.highlightColor;
                saveBtn.labelMinExtent = new Point(150, 18);
                saveBtn.labelShadowOffset = new Point(0, 0);
                saveBtn.labelShadowColor = new Color(0, 0, 0, 0);
                saveBtn.labelColor = new Color(0, 0, 0);
                saveBtn.contrast = mySelf.buttonContrast;
                saveBtn.labelBold = false;
                saveBtn.label.isBold = false;
                saveBtn.drawNew();
                saveBtn.hint = localize('Save project');
                saveBtn.setPosition(new Point(300, 3));
                ide.controlBar.add(saveBtn);
                saveBtn.fixLayout();
                ide.controlBar.cloudButton = saveBtn;
                ide.controlBar.fixLayout();
                ide.controlBar.label.destroy();
                ide.controlBar.updateLabel = nop;
            }
        };
    });




    function saveToDocShare() {
        ide.showMessage('Save in progress...\nWait until you return to this project');
        window.onbeforeunload = function() {

        };

        var form = document.createElement('FORM');
        form.action = this.docShareApp;
        form.method = "POST";

        var inp = document.createElement('INPUT');
        inp.type = "HIDDEN";
        inp.name = "content";

        inp.value = window.btoa(unescape(encodeURIComponent(ide.serializer.serialize(ide.stage))));
        form.appendChild(inp);

        inp = document.createElement('INPUT');
        inp.type = "HIDDEN";
        inp.name = "html";
        inp.value = "Snap";
        form.appendChild(inp);

        inp = document.createElement('INPUT');
        inp.type = "HIDDEN";
        inp.name = "id";
        inp.value = this.docShareFileID;
        form.appendChild(inp);

        inp = document.createElement('INPUT');
        inp.type = "SUBMIT";
        inp.value = " ";
        form.appendChild(inp);

        window.document.body.appendChild(form);

        form.submit();
    }
};
