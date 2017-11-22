/*Naturaleza Empleador*/
IF OBJECT_ID('NAE','U') IS NOT NULL DROP TABLE NAE
GO
CREATE TABLE [dbo].[NAE](
	[NaturalezaID] [varchar](2) NOT NULL,
	[DescripcionNaturaleza] [varchar](50) NOT NULL,
)
GO
ALTER TABLE [dbo].[NAE] ADD CONSTRAINT [NAENaturalezaID] PRIMARY KEY CLUSTERED ([NaturalezaID] ASC)


