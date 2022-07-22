# Example (Heading 1)

This is the [example page](/example) to demonstrate Markdown features and evaluation of inline PHP code.

## Markdown (Heading 2)

Hello World!

### Styling (Heading 3)

*This text is italic*.

**This text is bold**.

__This text is underlined__.

#### Code (Heading 4)

`This is inline code, which cannot span multiple lines.`

```
This is a code block with no language.

Code blocks can span...
   ...multiple lines!
```

This is a code block with C++ syntax highlighting.

```cpp
#include <iostream>

int main() {
	std::cout << "Hello World!" << std::endl;

	return 0;
}
```

This is a code block with JavaScript syntax highlighting.

```js
const myValue = 57;

function helloWorld()
	console.log( "Hello World!", myValue );
}

helloWorld();
```

##### Links and Images (Heading 5)

[This is a link](/).

![This is my avatar](/image/avatar/circle-128.webp)

###### Tables (Heading 6)

| No. | Name    | Car      | City            |
| --- | ------- | -------- | --------------- |
| 1   | Nicholle | Nissan   | Sumurgeneng    |
| 2   | Bobbe    | BMW      | Profítis Ilías |
| 3   | Gardiner | Dodge    | Dongkan        |
| 4   | Armando  | Mazda    | Camilaca       |
| 5   | Chucho   | Chrysler | Wawer          |

No. | Name | Car | City
--- | --- | --- | ---
1 | Nicholle | Nissan | Sumurgeneng
2 | Bobbe | BMW | Profítis Ilías
3 | Gardiner | Dodge | Dongkan
4 | Armando | Mazda | Camilaca
5 | Chucho | Chrysler | Wawer

## PHP code (Heading 2)

The name of the virtual-host handling this website is `<?= $_SERVER[ 'SERVER_NAME' ] ?>`.

### Request (Heading 3)

* Method: `<?= $_SERVER[ 'REQUEST_METHOD' ] ?>`
* Path: `<?= $_SERVER[ 'REQUEST_URI' ] ?>`
* Timestamp: `<?= $_SERVER[ 'REQUEST_TIME' ] ?>`
* User-Agent: `<?= $_SERVER[ 'HTTP_USER_AGENT' ] ?>`

### Software (Heading 3)

1. Server: `<?= $_SERVER[ 'SERVER_SOFTWARE' ] ?>`
2. PHP: `<?= phpversion() ?>`
3. You!
