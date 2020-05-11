<style>
    code {
        background: darkgray;
        border: #666666 2px solid;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 30px;
        display: block;
    }
</style>
<div class="container">
    <h1>Simple test api Documentation</h1>
    <table width="100%" border="0" cellpadding="10">
        <tr>
            <td width="33%">
                <h2>Publisher</h2>


                <p><strong>publisher/index</strong></p>
                <code>
                    curl -X GET 'http://<?=$_SERVER['HTTP_HOST'];?>/publisher'
                </code>


                <p><strong>publisher/view</strong></p>
                <code>
                    curl -X GET 'http://<?=$_SERVER['HTTP_HOST'];?>/publisher?id=1'
                </code>

                <p><strong>publisher/create</strong></p>
                <code>
                    curl -X POST 'http://<?=$_SERVER['HTTP_HOST'];?>/publisher/?name=Custom Publisher'
                </code>

                <p><strong>publisher/update</strong></p>
                <code>
                    curl -X PUT 'http://<?=$_SERVER['HTTP_HOST'];?>/publisher?id=1&name=New Publisher Name'
                </code>

                <p><strong>publisher/delete</strong></p>
                <code>
                    curl -X DELETE 'http://<?=$_SERVER['HTTP_HOST'];?>/publisher?id=4'
                </code>


            </td>


            <td width="33%">
                <h2>Author</h2>


                <p><strong>author/index</strong></p>
                <code>
                    curl -X GET 'http://<?=$_SERVER['HTTP_HOST'];?>/author'
                </code>


                <p><strong>author/view</strong></p>
                <code>
                    curl -X GET 'http://<?=$_SERVER['HTTP_HOST'];?>/author?id=1'
                </code>

                <p><strong>author/create</strong></p>
                <code>
                    curl -X POST 'http://<?=$_SERVER['HTTP_HOST'];?>/author/?name=Custom author name'
                </code>

                <p><strong>author/update</strong></p>
                <code>
                    curl -X PUT 'http://<?=$_SERVER['HTTP_HOST'];?>/author?id=1&name=Updated Author Name'
                </code>

                <p><strong>author/delete</strong></p>
                <code>
                    curl -X DELETE 'http://<?=$_SERVER['HTTP_HOST'];?>/author?id=4'
                </code>


            </td>


            <td width="33%">

                <h2>Book</h2>


                <p><strong>book/index</strong></p>
                <code>
                    curl -X GET 'http://<?=$_SERVER['HTTP_HOST'];?>/book'
                </code>


                <p><strong>book/view</strong></p>
                <code>
                    curl -X GET 'http://<?=$_SERVER['HTTP_HOST'];?>/book?id=1'
                </code>

                <p><strong>book/create</strong></p>
                <code>
                    curl -X POST 'http://<?=$_SERVER['HTTP_HOST'];?>//book?name=YourBookTitle&author=1&publisher=1'
                </code>

                <p><strong>book/update</strong></p>
                <code>
                    curl -X PUT 'http://<?=$_SERVER['HTTP_HOST'];?>/book?id=1&name=Fixed Book Name&author[]=1&author[]=2&publisher=1'
                </code>

                <p><strong>author/delete</strong></p>
                <code>
                    curl -X DELETE 'http://<?=$_SERVER['HTTP_HOST'];?>/book?id=5'
                </code>

            </td>
        </tr>
    </table>

</div>