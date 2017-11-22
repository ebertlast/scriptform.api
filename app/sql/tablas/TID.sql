/*Tipos de Documentos de Identidad*/
IF OBJECT_ID('TID','U') IS NOT NULL DROP TABLE TID
GO
CREATE TABLE [dbo].[TID](
	[TipoID] [varchar](2) NOT NULL,
	[DescripcionID] [varchar](50) NOT NULL,
	[LargoID] [int] NOT NULL,
	[TipoDatoID] [varchar](10) NOT NULL,
	[PersonaNatural] [bit] NOT NULL,
	[PersonaJuridica] [bit] NOT NULL,
) 
GO
ALTER TABLE TID ADD CONSTRAINT TIDTipoId PRIMARY KEY CLUSTERED (TipoId ASC)



