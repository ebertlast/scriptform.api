/*Detalle de Procedimientos*/
IF OBJECT_ID('USGRUH','U') IS NOT NULL DROP TABLE USGRUH
GO
CREATE TABLE [dbo].[USGRUH](
	[GrupoID] [varchar](30) NOT NULL,
	[ProcedimientoID] [varchar](30) NOT NULL,
	[ControlID] [varchar](100) NOT NULL,
    [Permiso] bit DEFAULT 0
)
GO
ALTER TABLE [dbo].[USGRUH] ADD CONSTRAINT [USGRUHGrupoIDProcedimientoIDControlID] PRIMARY KEY CLUSTERED ([GrupoID] ASC, [ProcedimientoID] ASC, [ControlID] ASC)
GO
ALTER TABLE [dbo].[USGRUH] ADD CONSTRAINT [USGRUHGrupoID] FOREIGN KEY (GrupoID) REFERENCES USGRU(GrupoID)
GO
ALTER TABLE [dbo].[USGRUH] ADD CONSTRAINT [USGRUHProcedimientoIDControlID] FOREIGN KEY (ProcedimientoID, ControlID) REFERENCES USPROH(ProcedimientoID, ControlID)
GO