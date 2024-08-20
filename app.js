/*
 * Author: James McConnel
 * Personal website NodeJS, with Express, EJS and Markdown-It
 *
 * Usage: node app.js [hostname]:[port]
 *   Hostname: localhost, ANY, ip
 *   Port: any valid port number
 * */

const fs = require('fs');
const express = require('express');
const path = require('path');
const bodyParser = require('body-parser');
const ejs = require('ejs');
const markdownit = require('markdown-it');
const app = express();
const md = markdownit();


// Local modules
const Page = require('./javascript/Page.js');

app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');
app.set('view options', {outputFunctionName: "echo"});

   
//Middle ware (use-es)
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended: false}));
app.use(express.static(path.join(__dirname, 'public')));

//console.log(process.argv);

// App local variable definitions 
// Allows server to be started in local or network mode.
// node app.js [hostname]:[port]
//   hostname = ANY will allow server to be accessed by any networked machine that can reference this one.
if(process.argv.length > 2) {
   if(process.argv[2].includes(':')) {
      let temp = process.argv[2].split(':');
      if(temp[0].toUpperCase() === 'ANY') {
         app.locals.clHostName = null;
      } else if(temp[0]) {
         app.locals.clHostName = temp[0];
      } else app.locals.clHostName = "localhost";
      console.log("Parsed hostname: "+app.locals.clHostName);
      if(temp[1]) {
         app.locals.clPort = temp[1];
      } else {
         app.locals.clPort = 8000;
      }
   } 
}else {
   app.locals.clHostName = "localhost";
   app.locals.clPort = 8000;
}

app.locals.sysRoot = '/home/james/projects/homestead';

let page_details = JSON.parse(fs.readFileSync('./javascript/pageDetails.json'));
let pageNames = Object.keys(page_details);

for(let i = 0; i < pageNames.length; i++) {
   console.log(page_details[pageNames[i]]);
   Page.app = app;
   Page.pages[i] = new Page(page_details[pageNames[i]]);
   //console.log(currentPage);
   app.get(Page.pages[i].path, (req, res) => {return Page.pages[i].renderCallback(req, res);});
}

app.listen(app.locals.clPort, app.locals.clHostName, 
   () => console.log('Homestead started listening on '+ app.locals.clHostName+':'+app.locals.clPort+'...')
);

