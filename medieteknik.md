# empty
## 1. License
The license for Codeigniter can be found in "license_CodeIgniter.txt"

Copyright (C) 2011 by Medietekniksektionen

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

## 2. Developing medieteknik.nu
This application in developed for the Students Association for Media Technology at Linköping University.
To get started developing this application, please refer to [the Get started wiki page](https://github.com/medieteknik/Medieteknik.nu/wiki/Get-started-with-the-development-of-medieteknik.nu).

### Less
The system uses Less, currently being rendered on the run.

### .htaccess
To enable pretty urls, the following should be added into <code>.htaccess</code> file in the root of this repo:


> <IfModule mod_rewrite.c> \n
>   RewriteEngine On \n
>   `# !IMPORTANT! Set your RewriteBase here and don't forget trailing and leading`\n
>   `#  slashes.` \n
>   `# If your page resides at `\n
>   `#  http://www.example.com/mypage/test1 `\n
>   `# then use `\n
>   `# RewriteBase /mypage/test1/ `\n
>   RewriteBase / \n
>   RewriteCond %{REQUEST_FILENAME} !-f \n
>   RewriteCond %{REQUEST_FILENAME} !-d \n
>   RewriteRule ^(.*)$ index.php?/$1 [L] \n
> </IfModule> \n
> \n
> <IfModule !mod_rewrite.c> \n
>   `# If we don't have mod_rewrite installed, all 404's` \n
>   `# can be sent to index.php, and everything works as normal.` \n
>   `# Submitted by: ElliotHaughin` \n
> \n
>   ErrorDocument 404 /index.php \n
> </IfModule> \n


## 3. Demo/Dev URL
[http://dev.medieteknik.nu/](http://dev.medieteknik.nu/)

## 5. Contact Information
Questions about the system:
	webbchef@medieteknik.nu

Questions about content on medieteknik.nu
	styrelsen@medieteknik.nu