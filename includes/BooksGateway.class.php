<?php
    include_once "TableDataGateway.class.php";
    class BooksGateway extends TableDataGateway {
        private $db;
        public function __constract($db) {
            parent::__constract($db);
        }
        
        public function getSelectStatement() {
            return "select BookID, ISBN10, ISBN13, Title, CopyrightYear, Books.SubcategoryID, Books.ImprintID, 
            ProductionStatusID, Books.BindingTypeID, TrimSize, PageCountsEditorialEst, LatestInstockDate, 
            Description, CoverImage, SubcategoryName, Imprint, BindingType, Status from Books 
            INNER JOIN Subcategories ON Books.SubcategoryID=Subcategories.SubcategoryID 
            INNER JOIN Imprints ON Books.ImprintID=Imprints.ImprintID 
            INNER JOIN Statuses ON Statuses.StatusID=Books.ProductionStatusID 
            INNER JOIN BindingTypes ON BindingTypes.BindingTypeID=Books.BindingTypeID ";
        }
        
        public function getOrderFields() {
            return "Title";
        }
        
        public function getPrimaryKeyName() {
            return "ISBN10";
        }
        
        public function getSubcategoryName() {
            return "SubcategoryName";
        }
        
        public function getImprintName() {
            return "Imprint";
        }
        
        public function getSubcategories() {
            return "select SubcategoryName from Subcategories order by SubcategoryName ASC";
        }
        
        public function getImprint() {
            return "select Imprint from Imprints order by Imprint ASC";
        }
        
        public function getAuthors() {
            return "select FirstName, LastName, BookAuthors.Order, Books.ISBN10 from Authors 
            INNER JOIN BookAuthors ON BookAuthors.AuthorId=Authors.AuthorID 
            INNER JOIN Books ON Books.BookID=BookAuthors.BookId ";
        }
    }
?>