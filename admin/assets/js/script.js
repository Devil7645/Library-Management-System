const books = [
    { id: 'ASP-BO-01', title: 'The Great Gatsby', author: 'F. Scott Fitzgerald', genre: 'Fiction', lang: 'English', copies: 10, status: 'available' },
    { id: 'ASP-BO-02', title: 'To Kill a Mockingbird', author: 'George Orwell', genre: 'Ux-UI Design Book', lang: 'English', copies: 5, status: 'available' },
    { id: 'ASP-BO-03', title: 'Pirates of the Caribbean', author: 'Jane Austen', genre: 'Non-Fiction', lang: 'Tamil', copies: 3, status: 'lended' },
    { id: 'ASP-BO-04', title: 'Pride and Prejudice', author: 'J.D. Salinger', genre: 'Romance', lang: 'English', copies: 2, status: 'available' },
    { id: 'ASP-BO-05', title: 'Sapiens: A Brief History', author: 'Stephen Hawking', genre: 'Ux-UI Design Book', lang: 'English', copies: 1, status: 'damaged' },
    { id: 'ASP-BO-06', title: 'The Catcher in the Rye', author: 'John Peter', genre: 'Fiction', lang: 'English', copies: 5, status: 'damaged' },
    { id: 'ASP-BO-07', title: 'The Alchemist', author: 'Sara Jones', genre: 'Non-Fiction', lang: 'English', copies: 10, status: 'lended' },
    { id: 'ASP-BO-08', title: 'A Brief History of Time', author: 'Will Turner', genre: 'Science', lang: 'English', copies: 20, status: 'lended' },
    { id: 'ASP-BO-09', title: 'The Diary of a Young', author: 'Dwayne Smith', genre: 'Memoir', lang: 'English', copies: 30, status: 'lended' },
    { id: 'ASP-BO-10', title: 'Ux-UI Design Book', author: 'Anne Frank', genre: 'Visual Design', lang: 'English', copies: 50, status: 'lended' },
  ];
  
  const tbody = document.getElementById('bookTable');
  
  books.forEach(book => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td><input type="checkbox" /></td>
      <td>${book.id}</td>
      <td><a href="#">${book.title}</a></td>
      <td>${book.author}</td>
      <td>${book.genre}</td>
      <td>${book.lang}</td>
      <td>${book.copies}</td>
      <td><span class="status ${book.status}">${book.status.charAt(0).toUpperCase() + book.status.slice(1)}</span></td>
    `;
    tbody.appendChild(row);
  });