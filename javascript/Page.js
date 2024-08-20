const fs = require('fs');
const markdownit = require('markdown-it');
const md = markdownit();

/*
 * this.pageDetails needs to conform with the object sent to res.render
 * */
class Page {

   static pages = [];
   static app;

   fsDocs = "";
   pageDetails = [];

   constructor(pageDetails) {
      this.fsDocs = Page.app.locals.sysRoot+pageDetails.fsPath+'/docs/';
      this.pageDetails = pageDetails;
      this.pageDetails.post_content = this.getFileContents(this.fsDocs);
      //console.log(this.pageDetails);
   }

   renderCallback (req, res) {
      console.log(this.pageDetails);
      if(this) {
         console.log(this.pageDetails);
         //console.log(this);

         console.log("Received request at: "+this.pageDetails.path);
         if(req.query["id"]) {
            console.log("Query: "+req.query["id"]);
            this.pageDetails.post_content = this.getFileContents(this.fsDocs, req.query["id"]);
         }
         let pageProperties = this.pageDetails;
         pageProperties.postList = this.postList();
         res.render('page-index', pageProperties);
         return;
      }
      console.log("Page reference lost");
   }

   get path () {
      return this.pageDetails.path;
   }

   set currentQuery(newValue) {
      this.pageDetails.queryFileName = newValue;
   }

   get post_content () {
      return getFileContents(this.fsDocs, this.pageDetails.queryFileName);
   }

   // App specific functions 
   postList() {

      let nav = "\n<nav id='posts'><ul>\n";
      console.log(this.fsDocs);
      let docs = fs.readdirSync(this.fsDocs);
      let d = null;
      for(d of docs) {
        nav = nav + "<li><a href='?id="+d+"'>"+d+"</a></li>\n";
      }
      nav = nav+"</ul></nav>";
      return nav;
   }

   getFileContents(root, queryFileName='welcome.md') {
      //let fileStats = fs.statSync(root+queryFileName);
      if(fs.existsSync(root+queryFileName)) {
         if(queryFileName.endsWith('.md')) {
            return md.render(fs.readFileSync(root+queryFileName, 'utf8'));
         } else { 
            return md.render(fs.readFileSync(root+'welcome.md', 'utf8'));
         }
      } else {
         return md.render(fs.readFileSync(root+'welcome.md', 'utf8'));
      }
   }


};
module.exports = Page;
