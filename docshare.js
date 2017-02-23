WorldMorph.prototype.isDocShare = false;

WorldMorph.prototype.setDocShare = function(_params) {
    var saveBtn;
    var mySelf = this;
    this.docShareApp = _params.app;
    this.docShareFileID = _params.id;
    this.docShareFile = _params.file;
    this.isDocShare = (this.docShareApp !== "");
    var ide = world.children[0];

    ide.setLanguage(navigator.language || navigator.userLanguage,function(){
        ide.openProjectString(decodeURIComponent(escape(window.atob(mySelf.docShareFile))));

        if (mySelf.docShareApp !== "") {
            saveBtn = new PushButtonMorph(
                mySelf,
                saveToDocShare,
                localize('Save')
            );
            saveBtn.padding = 0;
            saveBtn.fontSize = 14;
            saveBtn.corner = 12;
            saveBtn.color = new Color(137,211,255);
            saveBtn.highlightColor = saveBtn.color.darker();
            saveBtn.pressColor = saveBtn.highlightColor;
            saveBtn.labelMinExtent = new Point(150, 18);
            saveBtn.labelShadowOffset = new Point(0, 0);
            saveBtn.labelShadowColor = saveBtn.highlightColor;
            saveBtn.labelColor = new Color(0,0,0);
            saveBtn.contrast = mySelf.buttonContrast;
            saveBtn.drawNew();
            saveBtn.hint = localize('Save project');
            saveBtn.setPosition(new Point(500, 3));
            ide.add(saveBtn);
            ide.fixLayout();
            saveBtn.fixLayout();
        }

    });


    function saveToDocShare() {
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
