/*Departamentos*/
IF OBJECT_ID('DEP','U') IS NOT NULL DROP TABLE DEP
GO
CREATE TABLE [dbo].[DEP](
	[DepartamentoID] [varchar](2) NOT NULL,
	[DescripcionDepartamento] [varchar](20) NOT NULL,
)
GO
ALTER TABLE [dbo].[DEP] ADD CONSTRAINT [DEPDepartamentoID] PRIMARY KEY CLUSTERED ([DepartamentoID] ASC)



