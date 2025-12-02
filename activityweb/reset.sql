-- Add to your existing LeRayAestheticDB
USE LeRayAestheticDB;
GO

-- Create Password Reset Tokens table
CREATE TABLE PasswordResetTokens (
    TokenID INT PRIMARY KEY IDENTITY(1,1),
    CustomerID INT FOREIGN KEY REFERENCES Customers(CustomerID),
    Token NVARCHAR(100) UNIQUE NOT NULL,
    ExpirationDate DATETIME NOT NULL,
    IsUsed BIT DEFAULT 0
);

-- Add Password column to Customers table if not exists
IF NOT EXISTS (SELECT * FROM sys.columns WHERE object_id = OBJECT_ID('Customers') AND name = 'Password')
BEGIN
    ALTER TABLE Customers ADD Password NVARCHAR(255) NULL;
END