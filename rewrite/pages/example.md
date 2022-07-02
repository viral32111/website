# Test

This is a testing page to demonstrate executing PHP code inside of a Markdown file.

I want to revisit the concept of storing each page as a Markdown file, then parsing and rendering it as HTML for browser visitors.
Command-line visitors *(i.e. cURL)* will show the page in either a plain-text or Markdown format.

Pages *(Markdown files)* without PHP code can also be [GPG signed](https://gnupg.org), as their content is static. This is another feature I tried out in the past, but scrapped in the final release of the website.

For example, the name of the virtual host handling this request is `<?php echo( $_SERVER[ 'SERVER_NAME' ] ); ?>`.

## Why?

Markdown works well for my website, as it has been designed in a minimalistic, plain-text-eske style.

It makes each page easier to edit too, and **removes the need for all the boilerplate template code on each page**.

Headers *(title, navigation bar)* and footers *(copyright notice)* will be automatically added to the rendered HTML.

The navigation bar will automatically change when pages *(Markdown files)* are added, removed or renamed *(the file name will be used as the page title)*.

Pages *(Markdown files)* will be stored in a separate directory. Likely outside of the document root, as they will not be directly accessed, instead parsed by a main PHP script responsible for handling all requests.
