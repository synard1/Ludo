const fs = require('fs');
const terser = require('terser');

const sourceDir = 'resources/_keenthemes/src/js'; // Adjust this to your source directory
const targetDir = 'public/assets/js'; // Adjust this to your target directory

// Get a list of JavaScript files in the source directory
const jsFiles = fs.readdirSync(sourceDir).filter(file => file.endsWith('.js'));

// Process each JavaScript file
jsFiles.forEach(file => {
  const sourcePath = `${sourceDir}/${file}`;
  const targetPath = `${targetDir}/${file}`;

  // Read the original code
  const code = fs.readFileSync(sourcePath, 'utf8');

  // Minify and obfuscate the code
  const result = terser.minify(code, {
    mangle: true,
    compress: true,
  });

  // Write the minified code to the target file
  fs.writeFileSync(targetPath, result.code);

  console.log(`Processed: ${file}`);
});
