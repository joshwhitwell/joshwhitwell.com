<template>
  <div class="type">
    <h1>This is an h1</h1>
    <h2>This is an h2</h2>
    <h3>This is an h3</h3>
    <h4>This is an h4</h4>
    <h5>This is an h5</h5>
    <h6>This is an h6</h6>
    <p>This is a paragraph</p>
    <p>
      <small>This is small text</small>
    </p>
    <p>
      <small class="extra-small"> This is extra small text </small>
    </p>
    <p>
      This is a paragraph with <strong>bold</strong> and <em>italic</em> text
    </p>
    <p>
      This is a paragraph with <a href="#">a link</a>,
      <a href="#">another link</a>, and <a href="#">a third link</a>
    </p>
    <p>This is a paragraph with <s>strikethrough</s> text</p>
    <p>
      This is a paragraph with <mark>highlighted</mark> and
      <u>underlined</u> text
    </p>
    <p>
      This is a paragraph with <abbr title="abbreviation">abbr</abbr> and
      <cite>cite</cite> text
    </p>
    <p>
      This is a paragraph with <sup>superscript</sup> and
      <sub>subscript</sub> text
    </p>
    <p>
      This is a paragraph with <del>deleted</del> and <ins>inserted</ins> text
    </p>
    <p>
      This is a paragraph with <code>code</code> and <kbd>keyboard input</kbd>
    </p>
    <details>
      <summary>This is a details summary</summary>
      <p>This is a details paragraph</p>
    </details>
    <ul>
      <li>This is a list item</li>
      <li>This is a list item</li>
      <li>This is a list item</li>
    </ul>
    <ol>
      <li>This is a list item</li>
      <li>This is a list item</li>
      <li>This is a list item</li>
    </ol>
    <dl>
      <dt>This is a definition term</dt>
      <dd>This is a definition description</dd>
    </dl>
    <blockquote>
      This is a blockquote with a citation
      <cite>—Citation</cite>
    </blockquote>
    <pre>
      This is preformatted text
      with multiple lines
    </pre>
    <figure>
      <img src="https://via.placeholder.com/150" alt="Placeholder" />
      <figcaption>This is a figure caption</figcaption>
    </figure>
    <table>
      <caption>
        This is a table caption
      </caption>
      <thead>
        <tr>
          <th>Header</th>
          <th>Header</th>
          <th>Header</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Data</td>
          <td>Data</td>
          <td>Data</td>
        </tr>
        <tr>
          <td>Data</td>
          <td>Data</td>
          <td>Data</td>
        </tr>
        <tr>
          <td>Data</td>
          <td>Data</td>
          <td>Data</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td>Footer</td>
          <td>Footer</td>
          <td>Footer</td>
        </tr>
      </tfoot>
    </table>
    <form>
      <fieldset>
        <legend>Legend</legend>
        <label for="input">Label</label>
        <input type="text" id="input" />
        <button type="submit">Button</button>
      </fieldset>
    </form>
  </div>
</template>
