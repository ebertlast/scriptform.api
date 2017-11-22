/*Tipos de Usuario*/
IF OBJECT_ID('TIPU','U') IS NOT NULL DROP TABLE TIPU
GO
CREATE TABLE [dbo].[TIPU](
	[TipoUsuarioId] [varchar](20) NOT NULL,
	[DescripcionTipoUsuario] [varchar](20) NOT NULL,
	[LargoTipoUsuario] [int] NOT NULL,
	[TipoDatoTipoUsuario] [varchar](10) NOT NULL,
)
GO
ALTER TABLE [dbo].[TIPU] ADD CONSTRAINT [TIPUTipoUsuarioId] PRIMARY KEY CLUSTERED ([TipoUsuarioId] ASC)
GO

