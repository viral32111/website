#!/usr/bin/node

// Import modules
const fs = require( "fs" )

// Path to the markdown file that needs parsing
const filePath = process.argv[ 2 ]

// Read the markdown file
let fileContents = fs.readFileSync( filePath, {
	encoding: "utf-8"
} ).trim()

// Setup regular expression patterns
const patterns = {
	lists: /^\*\s(.+)/gm,
	underline: /__(.+)__/g,
	warning: /^\$\s(.+)$/gm,
	links: /\[(.+)\]\((.+)\)/gm
}

// Lists
let match0;
while ( ( match0 = patterns.lists.exec( fileContents ) ) !== null ) {
	const html = "<li>" + match0[ 1 ] + "</li>"

	const before = fileContents.substring( 0, match0.index )
	const after = fileContents.substring( match0.index + match0[ 0 ].length )

	fileContents = before + html + after;
}

// Underline
let match1;
while ( ( match1 = patterns.underline.exec( fileContents ) ) !== null ) {
	const html = "<u>" + match1[ 1 ] + "</u>"

	const before = fileContents.substring( 0, match1.index )
	const after = fileContents.substring( match1.index + match1[ 0 ].length )

	fileContents = before + html + after;
}

// Warning
let match2;
while ( ( match2 = patterns.warning.exec( fileContents ) ) !== null ) {
	const html = "<span class=\"warning\">" + match2[ 1 ] + "</span>"

	const before = fileContents.substring( 0, match2.index )
	const after = fileContents.substring( match2.index + match2[ 0 ].length )

	fileContents = before + html + after;
}

// Links
let match3;
while ( ( match3 = patterns.links.exec( fileContents ) ) !== null ) {
	const html = "<a href=\"" + match3[ 2 ] + "\">" + match3[ 1 ] + "</a>"

	const before = fileContents.substring( 0, match3.index )
	const after = fileContents.substring( match3.index + match3[ 0 ].length )

	fileContents = before + html + after;
}

// Paragraphs
let final = ""
fileContents.split( "\n\n" ).forEach( ( value, index ) => {
	let html = "<p>" + value + "</p>\n\n"
	final += html
} )


// Print
console.log( final.trim() )