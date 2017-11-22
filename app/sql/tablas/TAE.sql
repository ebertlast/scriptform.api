/*Tamaño Empleador*/
IF OBJECT_ID('TAE','U') IS NOT NULL DROP TABLE TAE
GO
CREATE TABLE [dbo].[TAE](
	[TamanoID] [varchar](2) NOT NULL,
	[DescripcionTamano] [varchar](30) NOT NULL,
)
GO
ALTER TABLE [dbo].[TAE] ADD CONSTRAINT [TAETamanoID] PRIMARY KEY CLUSTERED ([TamanoID] ASC)
GO
